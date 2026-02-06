<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LamaranController extends Controller
{
    /**
     * FITUR 5: Lihat Pelamar
     * Menampilkan daftar pelamar untuk lowongan tertentu
     */
    public function pelamar($id)
    {
        // Ambil data lowongan
        $lowongan = DB::table('lowongan')
            ->where('idLowongan', $id)
            ->first();

        if (!$lowongan) {
            return redirect()->route('pemberi-kerja.lowongan-saya')
                ->with('error', 'Lowongan tidak ditemukan');
        }

        // Ambil daftar pelamar dengan detail profil
        $pelamar = DB::table('lamaran')
            ->join('pekerja', 'lamaran.idPekerja', '=', 'pekerja.idPekerja')
            ->join('user', 'pekerja.idUser', '=', 'user.idUser')
            ->leftJoin('pekerjaan', 'lamaran.idLamaran', '=', 'pekerjaan.idLamaran')
            ->leftJoin('rating', 'pekerjaan.idPekerjaan', '=', 'rating.idPekerjaan')
            ->select(
                'lamaran.*',
                'user.nama',
                'user.email',
                'pekerja.keahlian',
                'pekerja.pengalaman',
                'pekerja.alamat',
                'pekerja.no_telp',
                DB::raw('COALESCE(AVG(rating.nilai_rating), 0) as rating_avg'),
                DB::raw('COUNT(DISTINCT rating.idRating) as total_rating')
            )
            ->where('lamaran.idLowongan', $id)
            ->groupBy(
                'lamaran.idLamaran',
                'lamaran.idPekerja',
                'lamaran.idLowongan',
                'lamaran.status_lamaran',
                'lamaran.tanggal_lamaran',
                'lamaran.created_at',
                'lamaran.updated_at',
                'user.nama',
                'user.email',
                'pekerja.keahlian',
                'pekerja.pengalaman',
                'pekerja.alamat',
                'pekerja.no_telp'
            )
            ->orderByRaw("
                CASE 
                    WHEN lamaran.status_lamaran = 'menunggu' THEN 1
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

            if ($lamaran->status_lamaran !== 'menunggu') {
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
                ->where('status_lamaran', 'menunggu')
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

            // 6. Buat notifikasi untuk pekerja yang diterima
            $pekerja = DB::table('pekerja')->where('idPekerja', $lamaran->idPekerja)->first();
            DB::table('notifikasi')->insert([
                'idUser' => $pekerja->idUser,
                'judul' => 'Lamaran Anda Diterima!',
                'pesan' => 'Selamat! Lamaran Anda telah diterima. Silakan hubungi pemberi kerja untuk detail lebih lanjut.',
                'status_baca' => 0,
                'created_at' => now(),
                'updated_at' => now()
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
                    'judul' => 'Update Lamaran',
                    'pesan' => 'Maaf, lamaran Anda tidak dapat kami terima kali ini. Tetap semangat mencari pekerjaan lainnya!',
                    'status_baca' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
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

            if ($lamaran->status_lamaran !== 'menunggu') {
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
            $pekerja = DB::table('pekerja')->where('idPekerja', $lamaran->idPekerja)->first();
            DB::table('notifikasi')->insert([
                'idUser' => $pekerja->idUser,
                'judul' => 'Update Lamaran',
                'pesan' => 'Maaf, lamaran Anda tidak dapat kami terima kali ini. Tetap semangat!',
                'status_baca' => 0,
                'created_at' => now(),
                'updated_at' => now()
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
        // TODO: Implementasi untuk pekerja melamar pekerjaan
        return redirect()->back()->with('success', 'Lamaran berhasil dikirim!');
    }
}