<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PekerjaController extends Controller
{
    /**
     * Menampilkan Dashboard Pekerja (Halaman Cari Kerja)
     */
    public function dashboard()
    {
        // Mengambil data lowongan yang statusnya aktif
        // Kita join dengan tabel lain untuk mendapatkan nama perusahaan/lokasi jika perlu
        // Sesuai wireframe, kita butuh: Judul, Deskripsi, Upah, Lokasi
        
        $lowongan = DB::table('lowongan')
            ->where('status', 'aktif')
            ->get();

        // Ambil notifikasi untuk pekerja yang sedang login
        $idUser = auth()->user()->idUser ?? null;
        $notifikasi = [];
        if ($idUser) {
            $notifikasi = DB::table('notifikasi')
                ->where('idUser', $idUser)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        }

        return view('pekerja.dashboard', compact('lowongan', 'notifikasi'));
    }

    /**
     * Halaman Cari Pekerjaan (Mungkin sama dengan dashboard di tahap awal ini)
     */
    public function cariPekerjaan()
    {
        return $this->dashboard();
    }
    
    /**
     * Detail Lowongan
     */
    public function detailLowongan($id)
    {
        // Ambil data lowongan dengan join ke tabel terkait
        $lowongan = DB::table('Lowongan')
            ->join('PemberiKerja', 'Lowongan.idPemberiKerja', '=', 'PemberiKerja.idPemberiKerja')
            ->join('User', 'PemberiKerja.idUser', '=', 'User.idUser')
            ->leftJoin('Lowongan_Kategori', 'Lowongan.idLowongan', '=', 'Lowongan_Kategori.idLowongan')
            ->leftJoin('Kategori', 'Lowongan_Kategori.id_kategori', '=', 'Kategori.id_kategori')
            ->where('Lowongan.idLowongan', $id)
            ->select(
                'Lowongan.*',
                'PemberiKerja.nama_perusahaan',
                'PemberiKerja.alamat as alamat_perusahaan',
                'PemberiKerja.no_telp as telp_perusahaan',
                'User.nama as nama_pemberi_kerja',
                'Kategori.nama_kategori'
            )
            ->first();
        
        // Jika lowongan tidak ditemukan
        if (!$lowongan) {
            abort(404, 'Lowongan tidak ditemukan');
        }
        
        return view('pekerja.lowongan.detail-pekerjaan', compact('lowongan'));
    }
    
    /**
     * Halaman Lamaran Saya
     */
    public function lamaran()
    {
        $idUser = auth()->user()->idUser ?? null;
        
        if (!$idUser) {
            return redirect()->route('login');
        }
        
        // Cari idPekerja dari user yang login
        $pekerja = DB::table('pekerja')
            ->where('idUser', $idUser)
            ->first();
            
        if (!$pekerja) {
            abort(403, 'Anda tidak terdaftar sebagai pekerja');
        }
        
        // Lamaran yang menunggu konfirmasi (status: pending/diajukan)
        $pending = DB::table('lamaran')
            ->join('lowongan', 'lamaran.idLowongan', '=', 'lowongan.idLowongan')
            ->join('PemberiKerja', 'lowongan.idPemberiKerja', '=', 'PemberiKerja.idPemberiKerja')
            ->where('lamaran.idPekerja', $pekerja->idPekerja)
            ->whereIn('lamaran.status_lamaran', ['pending', 'diajukan'])
            ->select(
                'lamaran.*',
                'lowongan.judul',
                'lowongan.lokasi',
                'lowongan.upah',
                'lowongan.idLowongan',
                'PemberiKerja.nama_perusahaan',
                'lamaran.created_at as tanggal_lamar'
            )
            ->orderBy('lamaran.created_at', 'desc')
            ->get();
        
        // Pekerjaan yang sedang dikerjakan (status: diterima/accepted atau status_pekerjaan: berjalan)
        $working = DB::table('lamaran')
            ->join('lowongan', 'lamaran.idLowongan', '=', 'lowongan.idLowongan')
            ->join('PemberiKerja', 'lowongan.idPemberiKerja', '=', 'PemberiKerja.idPemberiKerja')
            ->leftJoin('pekerjaan', 'lamaran.idLamaran', '=', 'pekerjaan.idLamaran')
            ->where('lamaran.idPekerja', $pekerja->idPekerja)
            ->where(function($query) {
                 // Kondisi 1: Explicitly running in Pekerjaan table
                 $query->where('pekerjaan.status_pekerjaan', 'berjalan')
                 // Kondisi 2: Legacy accepted (status lamaran diterima dan belum selesai di pekerjaan)
                       ->orWhere(function($q) {
                           $q->whereIn('lamaran.status_lamaran', ['diterima', 'accepted', 'sedang_dikerjakan'])
                             ->where(function($sub) {
                                 $sub->whereNull('pekerjaan.status_pekerjaan')
                                     ->orWhere('pekerjaan.status_pekerjaan', '!=', 'selesai');
                             });
                       });
            })
            ->select(
                'lamaran.*',
                'lowongan.judul',
                'lowongan.lokasi',
                'lowongan.upah',
                'lowongan.idLowongan',
                'PemberiKerja.nama_perusahaan',
                'lamaran.updated_at as tanggal_mulai',
                'pekerjaan.status_pekerjaan',
                'pekerjaan.idPekerjaan'
            )
            ->orderBy('lamaran.updated_at', 'desc')
            ->get();
        
        // Riwayat (status: selesai/ditolak di lamaran OR status_pekerjaan selesai)
        $completed = DB::table('lamaran')
            ->join('lowongan', 'lamaran.idLowongan', '=', 'lowongan.idLowongan')
            ->join('PemberiKerja', 'lowongan.idPemberiKerja', '=', 'PemberiKerja.idPemberiKerja')
            ->leftJoin('pekerjaan', 'lamaran.idLamaran', '=', 'pekerjaan.idLamaran')
            ->where('lamaran.idPekerja', $pekerja->idPekerja)
            ->where(function($query) {
                 $query->where('pekerjaan.status_pekerjaan', 'selesai')
                       ->orWhereIn('lamaran.status_lamaran', ['selesai', 'ditolak', 'rejected', 'completed']);
            })
            ->select(
                'lamaran.*',
                'lowongan.judul',
                'lowongan.lokasi',
                'lowongan.upah',
                'lowongan.idLowongan',
                'PemberiKerja.nama_perusahaan',
                'lamaran.updated_at as tanggal_selesai',
                'pekerjaan.status_pekerjaan',
                'pekerjaan.idPekerjaan'
            )
            ->orderBy('lamaran.updated_at', 'desc')
            ->get();
        
        return view('pekerja.lamaran', compact('pending', 'working', 'completed'));
    }
    
    /**
     * Halaman Profil Pekerja
     */
    public function profil()
    {
        $idUser = auth()->user()->idUser ?? null;
        
        if (!$idUser) {
            return redirect()->route('login');
        }
        
        // Ambil data pekerja
        $pekerja = DB::table('pekerja')
            ->where('idUser', $idUser)
            ->first();
            
        if (!$pekerja) {
            abort(403, 'Anda tidak terdaftar sebagai pekerja');
        }
        
        // Ambil rating pekerja dengan query langsung
        $ratingData = DB::table('rating')
            ->join('pekerjaan', 'rating.idPekerjaan', '=', 'pekerjaan.idPekerjaan')
            ->join('lamaran', 'pekerjaan.idLamaran', '=', 'lamaran.idLamaran')
            ->where('lamaran.idPekerja', $pekerja->idPekerja)
            ->where('rating.pemberi_rating', 'PemberiKerja')
            ->select(
                DB::raw('AVG(rating.nilai_rating) as rating_average'),
                DB::raw('COUNT(rating.idRating) as total_rating')
            )
            ->first();
        
        $rating = $ratingData->rating_average ?? 0;
        $totalRating = $ratingData->total_rating ?? 0;
        
        // Ambil pengalaman kerja (pekerjaan yang sudah selesai)
        $pengalamanKerja = DB::table('pekerjaan')
            ->join('lamaran', 'pekerjaan.idLamaran', '=', 'lamaran.idLamaran')
            ->join('lowongan', 'lamaran.idLowongan', '=', 'lowongan.idLowongan')
            ->join('PemberiKerja', 'lowongan.idPemberiKerja', '=', 'PemberiKerja.idPemberiKerja')
            ->where('lamaran.idPekerja', $pekerja->idPekerja)
            ->where('pekerjaan.status_pekerjaan', 'selesai')
            ->select(
                'lowongan.judul',
                'lowongan.deskripsi',
                'PemberiKerja.nama_perusahaan',
                'pekerjaan.tanggal_mulai',
                'pekerjaan.tanggal_selesai',
                DB::raw('DATEDIFF(pekerjaan.tanggal_selesai, pekerjaan.tanggal_mulai) as durasi_hari')
            )
            ->orderBy('pekerjaan.tanggal_selesai', 'desc')
            ->get()
            ->map(function($item) {
                // Format durasi
                if ($item->durasi_hari) {
                    if ($item->durasi_hari < 7) {
                        $item->durasi = $item->durasi_hari . ' hari';
                    } elseif ($item->durasi_hari < 30) {
                        $minggu = floor($item->durasi_hari / 7);
                        $item->durasi = $minggu . ' minggu';
                    } else {
                        $bulan = floor($item->durasi_hari / 30);
                        $item->durasi = $bulan . ' bulan';
                    }
                } else {
                    $item->durasi = '-';
                }
                return $item;
            });
        
    // Ambil ulasan terbaru
    $ulasanList = DB::table('rating')
        ->join('pekerjaan', 'rating.idPekerjaan', '=', 'pekerjaan.idPekerjaan')
        ->join('lamaran', 'pekerjaan.idLamaran', '=', 'lamaran.idLamaran')
        ->join('lowongan', 'lamaran.idLowongan', '=', 'lowongan.idLowongan')
        ->join('PemberiKerja', 'lowongan.idPemberiKerja', '=', 'PemberiKerja.idPemberiKerja')
        ->join('user', 'PemberiKerja.idUser', '=', 'user.idUser')
        ->where('lamaran.idPekerja', $pekerja->idPekerja)
        ->where('rating.pemberi_rating', 'PemberiKerja')
        ->select(
            'rating.nilai_rating',
            'rating.ulasan',
            'rating.created_at',
            'lowongan.judul as judul_pekerjaan',
            'user.nama as nama_pemberi_kerja'
        )
        ->orderBy('rating.created_at', 'desc')
        ->get();
    
    return view('pekerja.profil', compact('pekerja', 'rating', 'totalRating', 'pengalamanKerja', 'ulasanList'));
}

    /**
     * Halaman Profil Publik Pekerja (untuk pemberi kerja lihat)
     */
    public function profilPublik($id)
    {
        // Ambil data pekerja berdasarkan idPekerja
        $pekerja = DB::table('pekerja')
            ->join('user', 'pekerja.idUser', '=', 'user.idUser')
            ->where('pekerja.idPekerja', $id)
            ->select('pekerja.*', 'user.nama', 'user.email', 'user.foto_profil', 'user.alamat', 'user.no_hp')
            ->first();
            
        if (!$pekerja) {
            abort(404, 'Pekerja tidak ditemukan');
        }
        
        // Ambil rating pekerja
        $ratingData = DB::table('rating')
            ->join('pekerjaan', 'rating.idPekerjaan', '=', 'pekerjaan.idPekerjaan')
            ->join('lamaran', 'pekerjaan.idLamaran', '=', 'lamaran.idLamaran')
            ->where('lamaran.idPekerja', $pekerja->idPekerja)
            ->where('rating.pemberi_rating', 'PemberiKerja')
            ->select(
                DB::raw('AVG(rating.nilai_rating) as rating_average'),
                DB::raw('COUNT(rating.idRating) as total_rating')
            )
            ->first();
        
        $rating = $ratingData->rating_average ?? 0;
        $totalRating = $ratingData->total_rating ?? 0;
        
        // Ambil pengalaman kerja
        $pengalamanKerja = DB::table('pekerjaan')
            ->join('lamaran', 'pekerjaan.idLamaran', '=', 'lamaran.idLamaran')
            ->join('lowongan', 'lamaran.idLowongan', '=', 'lowongan.idLowongan')
            ->join('PemberiKerja', 'lowongan.idPemberiKerja', '=', 'PemberiKerja.idPemberiKerja')
            ->where('lamaran.idPekerja', $pekerja->idPekerja)
            ->where('pekerjaan.status_pekerjaan', 'selesai')
            ->select(
                'lowongan.judul',
                'lowongan.deskripsi',
                'PemberiKerja.nama_perusahaan',
                'pekerjaan.tanggal_mulai',
                'pekerjaan.tanggal_selesai',
                DB::raw('DATEDIFF(pekerjaan.tanggal_selesai, pekerjaan.tanggal_mulai) as durasi_hari')
            )
            ->orderBy('pekerjaan.tanggal_selesai', 'desc')
            ->get()
            ->map(function($item) {
                if ($item->durasi_hari) {
                    if ($item->durasi_hari < 7) {
                        $item->durasi = $item->durasi_hari . ' hari';
                    } elseif ($item->durasi_hari < 30) {
                        $minggu = floor($item->durasi_hari / 7);
                        $item->durasi = $minggu . ' minggu';
                    } else {
                        $bulan = floor($item->durasi_hari / 30);
                        $item->durasi = $bulan . ' bulan';
                    }
                } else {
                    $item->durasi = '-';
                }
                return $item;
            });
        
        // Ambil ulasan terbaru
        $ulasanList = DB::table('rating')
            ->join('pekerjaan', 'rating.idPekerjaan', '=', 'pekerjaan.idPekerjaan')
            ->join('lamaran', 'pekerjaan.idLamaran', '=', 'lamaran.idLamaran')
            ->join('lowongan', 'lamaran.idLowongan', '=', 'lowongan.idLowongan')
            ->join('PemberiKerja', 'lowongan.idPemberiKerja', '=', 'PemberiKerja.idPemberiKerja')
            ->join('user', 'PemberiKerja.idUser', '=', 'user.idUser')
            ->where('lamaran.idPekerja', $pekerja->idPekerja)
            ->where('rating.pemberi_rating', 'PemberiKerja')
            ->select(
                'rating.nilai_rating',
                'rating.ulasan',
                'rating.created_at',
                'lowongan.judul as judul_pekerjaan',
                'user.nama as nama_pemberi_kerja'
            )
            ->orderBy('rating.created_at', 'desc')
            ->get();
        
        return view('pekerja.profil', compact('pekerja', 'rating', 'totalRating', 'pengalamanKerja', 'ulasanList'));
    }
    
    /**
     * Update Profil Pekerja
     */
    public function updateProfil(Request $request)
    {
        $idUser = auth()->user()->idUser ?? null;
        
        if (!$idUser) {
            return redirect()->route('login');
        }
        
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'usia' => 'nullable|integer|min:17|max:100',
            'alamat' => 'nullable|string|max:500',
            'no_telp' => 'nullable|string|max:20',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'usia.min' => 'Usia minimal harus 17 tahun.',
            'usia.max' => 'Usia maksimal adalah 100 tahun.',
            'usia.integer' => 'Usia harus berupa angka.',
            'foto_profil.image' => 'File harus berupa gambar.',
            'foto_profil.max' => 'Ukuran foto maksimal 2MB.',
            'foto_profil.mimes' => 'Format foto harus jpeg, png, jpg, atau gif.'
        ]);
        
        try {
            // Update data user (nama)
            DB::table('user')
                ->where('idUser', $idUser)
                ->update([
                    'nama' => $request->nama,
                    'updated_at' => now()
                ]);
            
            // Prepare data pekerja
            $dataUpdate = [
                'usia' => $request->usia,
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
                'updated_at' => now()
            ];
            
            // Handle upload foto profil
            if ($request->hasFile('foto_profil')) {
                $file = $request->file('foto_profil');
                
                // Pastikan folder exist
                if (!\Illuminate\Support\Facades\Storage::disk('public')->exists('profil')) {
                    \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory('profil');
                }

                // Hapus foto lama jika ada
                $user = DB::table('user')->where('idUser', $idUser)->first();
                if ($user->foto_profil && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->foto_profil)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto_profil);
                }
                
                // Simpan foto baru
                $fileName = 'profil_' . $idUser . '_' . time() . '.' . $file->getClientOriginalExtension();
                
                // Simpan menggunakan Storage facade disk public
                $path = $file->storeAs('profil', $fileName, 'public');
                $relativePath = 'profil/' . $fileName;
                
                // Update foto di tabel user
                DB::table('user')
                    ->where('idUser', $idUser)
                    ->update([
                        'foto_profil' => $relativePath,
                        'updated_at' => now()
                    ]);
            }
            
            // Update data pekerja
            DB::table('pekerja')
                ->where('idUser', $idUser)
                ->update($dataUpdate);
            
            return redirect()
                ->route('pekerja.profil')
                ->with('success', 'Profil berhasil diperbarui!');
                
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal memperbarui profil: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Halaman Pengaturan
     */
    public function pengaturan()
    {
        return view('pekerja.pengaturan');
    }

    /**
     * Tambah Keahlian Baru
     */
    public function tambahKeahlian(Request $request)
    {
        $request->validate([
            'keahlian' => 'required|string|max:50'
        ]);

        try {
            $idUser = auth()->user()->idUser;
            $pekerja = DB::table('pekerja')->where('idUser', $idUser)->first();

            if (!$pekerja) {
                return redirect()->back()->with('error', 'Data pekerja tidak ditemukan.');
            }

            // Ambil keahlian lama, breakdown jadi array
            $currentSkills = $pekerja->keahlian ? explode(',', $pekerja->keahlian) : [];
            $newSkill = strip_tags(trim($request->keahlian));
            
            // Validasi duplikat
            foreach($currentSkills as $s) {
                if(strcasecmp(trim($s), $newSkill) == 0) {
                    return redirect()->back()->with('error', 'Keahlian tersebut sudah ada di daftar Anda.');
                }
            }

            // Tambahkan ke array
            $currentSkills[] = $newSkill;
            
            // Gabungkan kembali jadi string koma
            $skillString = implode(',', $currentSkills);

            // Update database
            DB::table('pekerja')
                ->where('idPekerja', $pekerja->idPekerja)
                ->update([
                    'keahlian' => $skillString, 
                    'updated_at' => now()
                ]);

            return redirect()->back()->with('success', 'Keahlian berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
