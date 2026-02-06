<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LamaranController extends Controller
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
     * FITUR 5: Lihat Pelamar
     * Menampilkan daftar pelamar untuk lowongan tertentu
     */
    public function pelamar($id)
    {
        // Pastikan pemberi kerja hanya bisa lihat lowongan miliknya
        $idPemberiKerja = $this->getIdPemberiKerja();
        
        // Ambil data lowongan
        $lowongan = DB::table('lowongan')
            ->where('idLowongan', $id)
            ->where('idPemberiKerja', $idPemberiKerja)
            ->first();

        if (!$lowongan) {
            abort(403, 'Anda tidak memiliki akses ke lowongan ini');
        }

        // Ambil daftar pelamar dengan detail profil dan rating
        $pelamar = DB::table('lamaran')
            ->join('pekerja', 'lamaran.idPekerja', '=', 'pekerja.idPekerja')
            ->join('user', 'pekerja.idUser', '=', 'user.idUser')
            ->select(
                'lamaran.*',
                'user.nama',
                'user.email',
                'pekerja.keahlian',
                'pekerja.pengalaman',
                'pekerja.alamat',
                'pekerja.no_telp',
                DB::raw('(
                    SELECT COALESCE(AVG(r.nilai_rating), 0)
                    FROM rating r
                    INNER JOIN pekerjaan p ON r.idPekerjaan = p.idPekerjaan
                    INNER JOIN lamaran l ON p.idLamaran = l.idLamaran
                    WHERE l.idPekerja = pekerja.idPekerja
                ) as rating_avg'),
                DB::raw('(
                    SELECT COUNT(DISTINCT r.idRating)
                    FROM rating r
                    INNER JOIN pekerjaan p ON r.idPekerjaan = p.idPekerjaan
                    INNER JOIN lamaran l ON p.idLamaran = l.idLamaran
                    WHERE l.idPekerja = pekerja.idPekerja
                ) as total_rating')
            )
            ->where('lamaran.idLowongan', $id)
            ->orderByRaw("
                CASE 
                    WHEN lamaran.status_lamaran = 'pending' THEN 1
                    WHEN lamaran.status_lamaran = 'diterima' THEN 2
                    WHEN lamaran.status_lamaran = 'ditolak' THEN 3
                END
            ")
            ->orderBy('lamaran.tanggal_lamaran', 'desc')
            ->get();

        return view('pemberi-kerja.lowongan.pelamar', compact('lowongan', 'pelamar'));
    }

    /**
     * FITUR 6: Pilih Pekerja (Terima Pelamar)
     * Menerima lamaran dan membuat pekerjaan baru
     */
    public function terimaPelamar(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            // 1. Ambil data lamaran
            $lamaran = DB::table('lamaran')->where('idLamaran', $id)->first();

            if (!$lamaran) {
                return redirect()->back()->with('error', 'Lamaran tidak ditemukan');
            }

            if ($lamaran->status_lamaran !== 'pending') {
                return redirect()->back()->with('error', 'Lamaran sudah diproses sebelumnya');
            }

            // 2. Update status lamaran menjadi 'diterima'
            DB::table('lamaran')
                ->where('idLamaran', $id)
                ->update([
                    'status_lamaran' => 'diterima',
                    'updated_at' => now()
                ]);

            // 3. Buat record baru di tabel pekerjaan
            DB::table('pekerjaan')->insert([
                'idLamaran' => $id,
                'tanggal_mulai' => now(),
                'tanggal_selesai' => null,
                'status_pekerjaan' => 'berjalan',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // 4. Tolak lamaran lain untuk lowongan yang sama
            DB::table('lamaran')
                ->where('idLowongan', $lamaran->idLowongan)
                ->where('idLamaran', '!=', $id)
                ->where('status_lamaran', 'pending')
                ->update([
                    'status_lamaran' => 'ditolak',
                    'updated_at' => now()
                ]);

            // 5. Update status lowongan menjadi 'tidak_aktif'
            DB::table('lowongan')
                ->where('idLowongan', $lamaran->idLowongan)
                ->update([
                    'status' => 'tidak_aktif',
                    'updated_at' => now()
                ]);

            // 5b. Masukkan ke tabel Pekerjaan (create job entry)
            DB::table('pekerjaan')->insert([
                'idLamaran' => $lamaran->idLamaran,
                'status_pekerjaan' => 'berjalan',
                'tanggal_mulai' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Info Lowongan untuk Notifikasi
            $infoLowongan = DB::table('lowongan')
                ->join('PemberiKerja', 'lowongan.idPemberiKerja', '=', 'PemberiKerja.idPemberiKerja')
                ->join('user', 'PemberiKerja.idUser', '=', 'user.idUser')
                ->where('lowongan.idLowongan', $lamaran->idLowongan)
                ->select('lowongan.judul', 'user.nama as nama_perusahaan')
                ->first();
                
            $judul = $infoLowongan->judul ?? 'Pekerjaan';
            $perusahaan = $infoLowongan->nama_perusahaan ?? 'Pemberi Kerja';
            $link = route('pekerja.lowongan.detail', $lamaran->idLowongan);

            // 6. Buat notifikasi untuk pekerja yang diterima
            $pekerja = DB::table('pekerja')->where('idPekerja', $lamaran->idPekerja)->first();
            DB::table('notifikasi')->insert([
                'idUser' => $pekerja->idUser,
                'pesan' => "Selamat! Lamaran Anda untuk <strong>{$judul}</strong> di <strong>{$perusahaan}</strong> telah diterima. <br><a href='{$link}' class='text-pelagic-blue font-bold hover:underline mt-1 inline-block'>Lihat Detail</a>",
                'is_read' => false,
                'tipe_notifikasi' => 'terima_lamaran',
                'created_at' => now()
            ]);

            // 7. Buat notifikasi untuk pelamar yang ditolak
            $pelamarDitolak = DB::table('lamaran')
                ->where('idLowongan', $lamaran->idLowongan)
                ->where('idLamaran', '!=', $id)
                ->where('status_lamaran', 'ditolak')
                ->get();

            foreach ($pelamarDitolak as $lamaranDitolak) {
                $pekerjaData = DB::table('pekerja')
                    ->where('idPekerja', $lamaranDitolak->idPekerja)
                    ->first();
                
                DB::table('notifikasi')->insert([
                    'idUser' => $pekerjaData->idUser,
                    'pesan' => "Maaf, lamaran Anda untuk <strong>{$judul}</strong> di <strong>{$perusahaan}</strong> belum diterima kali ini. Tetap semangat!",
                    'is_read' => false,
                    'tipe_notifikasi' => 'tolak_lamaran',
                    'created_at' => now()
                ]);
            }

            DB::commit();

            return redirect()
                ->route('pemberi-kerja.lowongan.pelamar', $lamaran->idLowongan)
                ->with('success', 'Pekerja berhasil dipilih! Pekerjaan telah dimulai.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * FITUR 6: Tolak Pelamar
     * Menolak lamaran pekerja
     */
    public function tolakPelamar($id)
    {
        try {
            DB::beginTransaction();

            // 1. Ambil data lamaran
            $lamaran = DB::table('lamaran')->where('idLamaran', $id)->first();

            if (!$lamaran) {
                return redirect()->back()->with('error', 'Lamaran tidak ditemukan');
            }

            if ($lamaran->status_lamaran !== 'pending') {
                return redirect()->back()->with('error', 'Lamaran sudah diproses sebelumnya');
            }

            // 2. Update status lamaran menjadi 'ditolak'
            DB::table('lamaran')
                ->where('idLamaran', $id)
                ->update([
                    'status_lamaran' => 'ditolak',
                    'updated_at' => now()
                ]);

            // 3. Buat notifikasi untuk pekerja
            
            // Ambil info lowongan dulu
            $infoLowongan = DB::table('lowongan')
                ->join('PemberiKerja', 'lowongan.idPemberiKerja', '=', 'PemberiKerja.idPemberiKerja')
                ->join('user', 'PemberiKerja.idUser', '=', 'user.idUser')
                ->where('lowongan.idLowongan', $lamaran->idLowongan)
                ->select('lowongan.judul', 'user.nama as nama_perusahaan')
                ->first();
                
            $judul = $infoLowongan->judul ?? 'Pekerjaan';
            $perusahaan = $infoLowongan->nama_perusahaan ?? 'Pemberi Kerja';

            $pekerja = DB::table('pekerja')->where('idPekerja', $lamaran->idPekerja)->first();
            DB::table('notifikasi')->insert([
                'idUser' => $pekerja->idUser,
                'pesan' => "Maaf, lamaran Anda untuk <strong>{$judul}</strong> di <strong>{$perusahaan}</strong> telah ditolak.",
                'is_read' => false,
                'tipe_notifikasi' => 'tolak_lamaran',
                'created_at' => now()
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Lamaran berhasil ditolak');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Halaman Daftar Lamaran Pekerja (untuk pekerja)
     */
    public function index()
    {
        // TODO: Implementasi untuk pekerja melihat lamaran mereka
        return view('pekerja.lamaran.index');
    }

    /**
     * Lamar Pekerjaan (untuk pekerja)
     */
    public function lamar(Request $request, $id)
    {
        try {
            $idUser = auth()->user()->idUser ?? null;
            
            if (!$idUser) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda harus login terlebih dahulu'
                ], 401);
            }
            
            // Cari idPekerja dari user yang login
            $pekerja = DB::table('pekerja')
                ->where('idUser', $idUser)
                ->first();
                
            if (!$pekerja) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak terdaftar sebagai pekerja'
                ], 403);
            }
            
            // Cek apakah sudah pernah melamar
            $sudahLamar = DB::table('lamaran')
                ->where('idLowongan', $id)
                ->where('idPekerja', $pekerja->idPekerja)
                ->exists();
                
            if ($sudahLamar) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah pernah melamar pekerjaan ini'
                ], 400);
            }
            
            // Insert lamaran baru
            DB::table('lamaran')->insert([
                'idLowongan' => $id,
                'idPekerja' => $pekerja->idPekerja,
                'tanggal_lamaran' => now()->format('Y-m-d'),
                'status_lamaran' => 'pending',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Lamaran berhasil dikirim!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}