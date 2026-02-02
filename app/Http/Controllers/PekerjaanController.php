<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PekerjaanController extends Controller
{
    /**
     * FITUR 7: Konfirmasi Pekerjaan Selesai
     * Mengubah status pekerjaan menjadi 'selesai'
     */
    public function konfirmasiSelesai(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            // 1. Ambil data pekerjaan
            $pekerjaan = DB::table('pekerjaan')
                ->join('lamaran', 'pekerjaan.idLamaran', '=', 'lamaran.idLamaran')
                ->join('lowongan', 'lamaran.idLowongan', '=', 'lowongan.idLowongan')
                ->join('pekerja', 'lamaran.idPekerja', '=', 'pekerja.idPekerja')
                ->select(
                    'pekerjaan.*',
                    'lamaran.idPekerja',
                    'lowongan.idPemberiKerja',
                    'lowongan.judul as judul_lowongan',
                    'pekerja.idUser as idUserPekerja'
                )
                ->where('pekerjaan.idPekerjaan', $id)
                ->first();

            if (!$pekerjaan) {
                return redirect()->back()->with('error', 'Pekerjaan tidak ditemukan');
            }

            if ($pekerjaan->status_pekerjaan === 'selesai') {
                return redirect()->back()->with('error', 'Pekerjaan sudah diselesaikan sebelumnya');
            }

            // 2. Update status pekerjaan menjadi 'selesai'
            DB::table('pekerjaan')
                ->where('idPekerjaan', $id)
                ->update([
                    'status_pekerjaan' => 'selesai',
                    'tanggal_selesai' => now(),
                    'updated_at' => now()
                ]);

            // 3. Buat notifikasi untuk pekerja
            DB::table('notifikasi')->insert([
                'idUser' => $pekerjaan->idUserPekerja,
                'judul' => 'Pekerjaan Selesai',
                'pesan' => "Pekerjaan '{$pekerjaan->judul_lowongan}' telah dikonfirmasi selesai. Jangan lupa berikan rating!",
                'status_baca' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Pekerjaan berhasil dikonfirmasi selesai! Anda dapat memberikan rating sekarang.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Halaman Daftar Pekerjaan
     */
    public function index()
    {
        // Ambil ID pemberi kerja dari user yang login
        // Sementara pakai dummy ID
        $idPemberiKerja = 1;

        $pekerjaan = DB::table('pekerjaan')
            ->join('lamaran', 'pekerjaan.idLamaran', '=', 'lamaran.idLamaran')
            ->join('lowongan', 'lamaran.idLowongan', '=', 'lowongan.idLowongan')
            ->join('pekerja', 'lamaran.idPekerja', '=', 'pekerja.idPekerja')
            ->join('user', 'pekerja.idUser', '=', 'user.idUser')
            ->select(
                'pekerjaan.*',
                'lowongan.judul',
                'lowongan.upah',
                'lowongan.lokasi',
                'user.nama as nama_pekerja',
                'lamaran.idPekerja',
                'lowongan.idPemberiKerja'
            )
            ->where('lowongan.idPemberiKerja', $idPemberiKerja)
            ->orderBy('Pekerjaan.created_at', 'desc')
            ->get();

        return view('pemberi-kerja.pekerjaan.index', compact('pekerjaan'));
    }

    /**
     * Detail Pekerjaan
     */
    public function show($id)
    {
        $pekerjaan = DB::table('pekerjaan')
            ->join('lamaran', 'pekerjaan.idLamaran', '=', 'lamaran.idLamaran')
            ->join('lowongan', 'lamaran.idLowongan', '=', 'lowongan.idLowongan')
            ->join('pekerja', 'lamaran.idPekerja', '=', 'pekerja.idPekerja')
            ->join('user', 'pekerja.idUser', '=', 'user.idUser')
            ->select(
                'pekerjaan.*',
                'lowongan.judul',
                'lowongan.deskripsi',
                'lowongan.upah',
                'lowongan.lokasi',
                'user.nama as nama_pekerja',
                'user.email as email_pekerja',
                'pekerja.keahlian',
                'pekerja.noHP',
                'lamaran.idPekerja',
                'lowongan.idPemberiKerja'
            )
            ->where('pekerjaan.idPekerjaan', $id)
            ->first();

        if (!$pekerjaan) {
            return redirect()->route('pemberi-kerja.dashboard')
                ->with('error', 'Pekerjaan tidak ditemukan');
        }

        // Cek apakah sudah ada rating
        $rating = DB::table('rating')
            ->where('idPekerjaan', $id)
            ->where('idPemberiKerja', $pekerjaan->idPemberiKerja)
            ->first();

        return view('pemberi-kerja.pekerjaan.detail', compact('pekerjaan', 'rating'));
    }
}