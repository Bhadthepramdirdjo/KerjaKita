<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PemberiKerjaController extends Controller
{
    /**
     * Helper: Ambil ID Pemberi Kerja dari user yang login
     */
    private function getIdPemberiKerja()
    {
        $idUser = Auth::id();
        $pemberiKerja = DB::table('PemberiKerja')->where('idUser', $idUser)->first();
        
        if (!$pemberiKerja) {
            // Jika tidak ada entry PemberiKerja, buat satu
            $user = Auth::user();
            if ($user->tipe_user !== 'PemberiKerja' && $user->peran !== 'PemberiKerja') {
                abort(403, 'User bukan pemberi kerja');
            }
            
            // Buat entry PemberiKerja jika belum ada
            $id = DB::table('PemberiKerja')->insertGetId([
                'idUser' => $idUser,
                'nama_perusahaan' => $user->nama,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            return $id;
        }
        
        return $pemberiKerja->idPemberiKerja;
    }
    
    /**
     * Menampilkan Dashboard Pemberi Kerja
     */
    public function dashboard()
    {
        // 1. Ambil ID Pemberi Kerja dari user yang login
        $idPemberiKerja = $this->getIdPemberiKerja();
        
        // Menggunakan Stored Procedure yang sudah ada di database Anda!
        // CALL sp_dashboard_pemberi_kerja($idPemberiKerja)
        // Namun untuk kompatibilitas Laravel, kita query manual saja agar aman
        
        $stats = [
            'lowongan_aktif' => DB::table('lowongan')->where('idPemberiKerja', $idPemberiKerja)->where('status', 'aktif')->count(),
            'pelamar_baru' => DB::table('lamaran')
                                ->join('lowongan', 'lamaran.idLowongan', '=', 'lowongan.idLowongan')
                                ->where('lowongan.idPemberiKerja', $idPemberiKerja)
                                ->where('lamaran.created_at', '>=', now()->today())
                                ->count(),
            'dalam_proses' => DB::table('pekerjaan')
                                ->join('lamaran', 'pekerjaan.idLamaran', '=', 'lamaran.idLamaran')
                                ->join('lowongan', 'lamaran.idLowongan', '=', 'lowongan.idLowongan')
                                ->where('lowongan.idPemberiKerja', $idPemberiKerja)
                                ->where('pekerjaan.status_pekerjaan', 'berjalan')
                                ->count(),
            'pekerjaan_selesai' => DB::table('pekerjaan')
                                ->join('lamaran', 'pekerjaan.idLamaran', '=', 'lamaran.idLamaran')
                                ->join('lowongan', 'lamaran.idLowongan', '=', 'lowongan.idLowongan')
                                ->where('lowongan.idPemberiKerja', $idPemberiKerja)
                                ->where('pekerjaan.status_pekerjaan', 'selesai')
                                ->count(),
        ];

        // Hitung pekerja yang menunggu konfirmasi (status diterima tapi belum ada pekerjaan)
        $pekerjaMenunggu = DB::table('lamaran')
            ->join('lowongan', 'lamaran.idLowongan', '=', 'lowongan.idLowongan')
            ->leftJoin('pekerjaan', 'lamaran.idLamaran', '=', 'pekerjaan.idLamaran')
            ->where('lowongan.idPemberiKerja', $idPemberiKerja)
            ->where('lamaran.status_lamaran', 'diterima')
            ->whereNull('pekerjaan.idPekerjaan')
            ->count();

        // Hitung notifikasi Lamaran Baru (badge di sidebar)
        $notifikasiLamaranBaru = DB::table('lamaran')
            ->join('lowongan', 'lamaran.idLowongan', '=', 'lowongan.idLowongan')
            ->where('lowongan.idPemberiKerja', $idPemberiKerja)
            ->where('lamaran.is_read', false)
            ->count();

        // 2. Ambil Daftar Lowongan Aktif (untuk Slider)
        // Tampilkan semua lowongan aktif + pekerjaan jika ada
        $pekerjaan = DB::table('lowongan')
            ->select(
                DB::raw('NULL as idPekerjaan'),
                DB::raw('"aktif" as status_pekerjaan'),
                DB::raw('NULL as tanggal_mulai'),
                DB::raw('NULL as tanggal_selesai'),
                'lowongan.idLowongan',
                'lowongan.judul', 
                'lowongan.upah', 
                'lowongan.lokasi',
                'lowongan.idPemberiKerja',
                DB::raw('NULL as idLamaran'),
                DB::raw('"Belum ada pekerja" as nama_pekerja')
            )
            ->where('idPemberiKerja', $idPemberiKerja)
            ->where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('pemberi-kerja.dashboard', compact('stats', 'pekerjaan', 'pekerjaMenunggu', 'notifikasiLamaranBaru'));
    }

    /**
     * Halaman Profil Pelamar (Read-Only)
     */
    public function profilPelamar($id)
    {
        // Ambil data pekerja berdasarkan ID Pekerja
        $pekerja = DB::table('pekerja')
            ->join('user', 'pekerja.idUser', '=', 'user.idUser')
            ->where('pekerja.idPekerja', $id)
            ->select('pekerja.*', 'user.nama', 'user.foto_profil', 'user.email')
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

        return view('pemberi-kerja.profil-pelamar', compact('pekerja', 'rating', 'totalRating', 'pengalamanKerja'));
    }
    
    /**
     * Halaman Pengaturan
     */
    public function pengaturan()
    {
        return view('pemberi-kerja.pengaturan');
    }
    
    /**
     * Halaman Form Buat Lowongan
     */
    public function buatLowongan()
    {
        return view('pemberi-kerja.lowongan.buat-lowongan');
    }
    
    /**
     * Simpan Lowongan Baru
     */
    public function simpanLowongan(Request $request)
    {
        // Validasi minimal fields
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'upah' => 'required',
            'status' => 'required|in:aktif,draft'
        ]);

        $idPemberiKerja = $this->getIdPemberiKerja();

        // Clean upah value - remove Rp and dots
        $upahValue = preg_replace('/[^0-9]/', '', $validated['upah']);
        
        if (empty($upahValue)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['upah' => 'Upah harus berupa angka']);
        }

        DB::table('lowongan')->insert([
            'idPemberiKerja' => $idPemberiKerja,
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'lokasi' => $validated['lokasi'],
            'upah' => (int) $upahValue,
            'status' => $validated['status'],
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $message = $validated['status'] === 'aktif' 
            ? 'Lowongan berhasil dipublikasikan!' 
            : 'Lowongan berhasil disimpan sebagai draft!';

        return redirect()->route('pemberi-kerja.lowongan-saya')->with('success', $message);
    }
    
    /**
     * Halaman Rekomendasi Pekerja
     */
    public function rekomendasiPekerja()
    {
        return view('pemberi-kerja.rekomendasi-pekerja');
    }
    
    /**
     * Halaman Lowongan Saya
     */
    public function lowonganSaya()
    {
        // Ambil ID pemberi kerja dari user yang login
        $idPemberiKerja = $this->getIdPemberiKerja();

        // Reset Notifikasi: Tandai lamaran baru sebagai sudah dibaca saat membuka halaman ini
        // Sesuai request user: "kalo pemberi kerja udah membuka halaman nya, notif nya hilang"
        DB::table('lamaran')
            ->join('lowongan', 'lamaran.idLowongan', '=', 'lowongan.idLowongan')
            ->where('lowongan.idPemberiKerja', $idPemberiKerja)
            ->where('lamaran.is_read', false)
            ->update(['lamaran.is_read' => true]);

    // Query lowongan berdasarkan pemberi kerja
    $lowongan = DB::table('lowongan')
        ->where('idPemberiKerja', $idPemberiKerja)
        ->leftJoin('lamaran', 'lowongan.idLowongan', '=', 'lamaran.idLowongan')
        ->leftJoin('pekerjaan', 'lamaran.idLamaran', '=', 'pekerjaan.idLamaran')
        ->leftJoin('pekerja', 'lamaran.idPekerja', '=', 'pekerja.idPekerja')
        ->leftJoin('user', 'pekerja.idUser', '=', 'user.idUser')
        ->leftJoin('rating', function($join) {
            $join->on('pekerjaan.idPekerjaan', '=', 'rating.idPekerjaan')
                 ->where('rating.pemberi_rating', '=', 'PemberiKerja');
        })
        ->select(
            'lowongan.idLowongan',
            'lowongan.judul',
            'lowongan.lokasi',
            'lowongan.status',
            DB::raw('COUNT(lamaran.idLamaran) as total_pelamar'),
            DB::raw('MAX(pekerjaan.status_pekerjaan) as status_pekerjaan'),
            DB::raw('MAX(pekerjaan.idPekerjaan) as idPekerjaan'),
            DB::raw('COUNT(rating.idRating) as is_rated'),
            DB::raw('MAX(CASE WHEN pekerjaan.idPekerjaan IS NOT NULL THEN user.nama ELSE NULL END) as nama_pekerja')
        )
        ->groupBy('lowongan.idLowongan', 'lowongan.judul', 'lowongan.lokasi', 'lowongan.status')
        ->orderBy('lowongan.created_at', 'desc')
        ->get();

        return view('pemberi-kerja.lowongan-saya', compact('lowongan'));
    }

    /**
     * Halaman Konfirmasi Pekerja
     */
    public function konfirmasiPekerja()
    {
        $idPemberiKerja = $this->getIdPemberiKerja();

        // Pekerja yang status lamarannya 'diterima' tapi belum ada pekerjaan (menunggu konfirmasi)
        $pekerjaMenunggu = DB::table('lamaran')
            ->join('pekerja', 'lamaran.idPekerja', '=', 'pekerja.idPekerja')
            ->join('lowongan', 'lamaran.idLowongan', '=', 'lowongan.idLowongan')
            ->leftJoin('pekerjaan', 'lamaran.idLamaran', '=', 'pekerjaan.idLamaran')
            ->select(
                'lamaran.idLamaran',
                'lamaran.tanggal_lamaran',
                'lamaran.created_at as tanggal_diterima',
                'lowongan.idLowongan',
                'lowongan.judul',
                'lowongan.lokasi',
                'pekerja.idPekerja',
                'pekerja.no_telp',
                'pekerja.idUser'
            )
            ->where('lowongan.idPemberiKerja', $idPemberiKerja)
            ->where('lamaran.status_lamaran', 'diterima')
            ->whereNull('pekerjaan.idPekerjaan')
            ->orderBy('lamaran.created_at', 'asc')
            ->get();

        // Ambil user data separately
        $userIds = $pekerjaMenunggu->pluck('idUser')->unique()->filter();
        $users = DB::table('user')
            ->whereIn('idUser', $userIds)
            ->get()
            ->keyBy('idUser');

        // Merge user data into pekerjaMenunggu
        $pekerjaMenunggu = $pekerjaMenunggu->map(function($item) use ($users) {
            $user = $users->get($item->idUser);
            $item->nama_pekerja = $user ? $user->nama : 'Unknown';
            $item->email = $user ? $user->email : 'N/A';
            return $item;
        });

        // Ambil rating data - join dengan pekerjaan dan lamaran untuk ambil idUser pekerja
        if ($userIds->count() > 0) {
            $ratings = DB::table('rating')
                ->join('pekerjaan', 'rating.idPekerjaan', '=', 'pekerjaan.idPekerjaan')
                ->join('lamaran', 'pekerjaan.idLamaran', '=', 'lamaran.idLamaran')
                ->join('pekerja', 'lamaran.idPekerja', '=', 'pekerja.idPekerja')
                ->whereIn('pekerja.idUser', $userIds)
                ->selectRaw('pekerja.idUser, AVG(rating.nilai_rating) as rating_avg, COUNT(rating.idRating) as total_rating')
                ->groupBy('pekerja.idUser')
                ->get()
                ->keyBy('idUser');
        } else {
            $ratings = collect();
        }

        // Merge rating data
        $pekerjaMenunggu = $pekerjaMenunggu->map(function($item) use ($ratings) {
            $rating = $ratings->get($item->idUser);
            $item->rating_avg = $rating ? $rating->rating_avg : 0;
            $item->total_rating = $rating ? $rating->total_rating : 0;
            return $item;
        });

        // Pekerja yang sudah dikonfirmasi (ada pekerjaan aktif)
        $pekerjaDikonfirmasi = DB::table('lamaran')
            ->join('pekerjaan', 'lamaran.idLamaran', '=', 'pekerjaan.idLamaran')
            ->join('pekerja', 'lamaran.idPekerja', '=', 'pekerja.idPekerja')
            ->join('lowongan', 'lamaran.idLowongan', '=', 'lowongan.idLowongan')
            ->select(
                'lamaran.idLamaran',
                'pekerjaan.idPekerjaan',
                'pekerjaan.status_pekerjaan',
                'pekerjaan.tanggal_mulai',
                'lowongan.judul',
                'pekerja.idPekerja',
                'pekerja.idUser',
                DB::raw('ROUND((DATEDIFF(CURDATE(), pekerjaan.tanggal_mulai) / 30) * 100, 0) as progress')
            )
            ->where('lowongan.idPemberiKerja', $idPemberiKerja)
            ->where('pekerjaan.status_pekerjaan', 'berjalan')
            ->orderBy('pekerjaan.tanggal_mulai', 'desc')
            ->get();

        // Ambil user data untuk pekerja aktif
        $userIdsDikonfirmasi = $pekerjaDikonfirmasi->pluck('idUser')->unique()->filter();
        $usersDikonfirmasi = DB::table('user')
            ->whereIn('idUser', $userIdsDikonfirmasi)
            ->get()
            ->keyBy('idUser');

        // Merge user data
        $pekerjaDikonfirmasi = $pekerjaDikonfirmasi->map(function($item) use ($usersDikonfirmasi) {
            $user = $usersDikonfirmasi->get($item->idUser);
            $item->nama_pekerja = $user ? $user->nama : 'Unknown';
            return $item;
        });

        return view('pemberi-kerja.konfirmasi-pekerja', compact('pekerjaMenunggu', 'pekerjaDikonfirmasi'));
    }

    /**
     * Publikasi Draft Lowongan
     */
    public function publikasiDraft($idLowongan)
    {
        $idPemberiKerja = $this->getIdPemberiKerja();

        // Pastikan lowongan milik pemberi kerja ini dan statusnya draft
        $lowongan = DB::table('lowongan')
            ->where('idLowongan', $idLowongan)
            ->where('idPemberiKerja', $idPemberiKerja)
            ->where('status', 'draft')
            ->first();

        if (!$lowongan) {
            return redirect()->route('pemberi-kerja.lowongan-saya')
                ->with('error', 'Lowongan tidak ditemukan atau sudah dipublikasi');
        }

        // Update status menjadi aktif
        DB::table('lowongan')
            ->where('idLowongan', $idLowongan)
            ->update([
                'status' => 'aktif',
                'updated_at' => now()
            ]);

        return redirect()->route('pemberi-kerja.lowongan-saya')
            ->with('success', 'Lowongan berhasil dipublikasikan!');
    }

    /**
     * Halaman Profil Pemberi Kerja
     */
    public function profil()
    {
        $idPemberiKerja = $this->getIdPemberiKerja();
        $user = Auth::user();
        
        $pemberiKerja = DB::table('PemberiKerja')
            ->where('idPemberiKerja', $idPemberiKerja)
            ->first();

        return view('pemberi-kerja.profil', compact('user', 'pemberiKerja'));
    }

    /**
     * Update Profil Pemberi Kerja
     */
    public function updateProfil(Request $request)
    {
        $idPemberiKerja = $this->getIdPemberiKerja();
        $user = Auth::user();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:user,email,' . $user->idUser . ',idUser',
            'nama_perusahaan' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string|max:20',
            'foto_profil' => 'nullable|image|max:2048'
        ]);

        // Update user data
        DB::table('user')
            ->where('idUser', $user->idUser)
            ->update([
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'foto_profil' => $user->foto_profil, // Will update separately if new file
                'updated_at' => now()
            ]);

        // Update pemberi kerja data
        DB::table('PemberiKerja')
            ->where('idPemberiKerja', $idPemberiKerja)
            ->update([
                'nama_perusahaan' => $validated['nama_perusahaan'],
                'alamat' => $validated['alamat'],
                'no_telp' => $validated['no_telp'],
                'updated_at' => now()
            ]);

        // Handle profile picture upload
        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $fileName = 'profil_' . $user->idUser . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('profil', $fileName, 'public');

            DB::table('user')
                ->where('idUser', $user->idUser)
                ->update(['foto_profil' => 'profil/' . $fileName]);
        }

        return redirect()->route('pemberi-kerja.profil')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}
