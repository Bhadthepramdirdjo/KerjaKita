<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemberiKerjaController extends Controller
{
    /**
     * Menampilkan Dashboard Pemberi Kerja
     */
    public function dashboard()
    {
        // 1. Ambil Statistik
        // Di aplikasi nyata, kita filter berdasarkan ID user yang login
        // Saat ini kita pakai dummy ID karena belum login
        $idPemberiKerja = 1; 

        // Menggunakan Stored Procedure yang sudah ada di database Anda!
        // CALL sp_dashboard_pemberi_kerja(1)
        // Namun untuk kompatibilitas Laravel, kita query manual saja agar aman
        
        $stats = [
            'lowongan_aktif' => DB::table('Lowongan')->where('idPemberiKerja', $idPemberiKerja)->where('status', 'aktif')->count(),
            'pelamar_baru' => DB::table('Lamaran')
                                ->join('Lowongan', 'Lamaran.idLowongan', '=', 'Lowongan.idLowongan')
                                ->where('Lowongan.idPemberiKerja', $idPemberiKerja)
                                ->where('Lamaran.created_at', '>=', now()->today())
                                ->count(),
            'dalam_proses' => DB::table('Pekerjaan')
                                ->join('Lamaran', 'Pekerjaan.idLamaran', '=', 'Lamaran.idLamaran')
                                ->join('Lowongan', 'Lamaran.idLowongan', '=', 'Lowongan.idLowongan')
                                ->where('Lowongan.idPemberiKerja', $idPemberiKerja)
                                ->where('Pekerjaan.status_pekerjaan', 'berjalan')
                                ->count(),
            'pekerjaan_selesai' => DB::table('Pekerjaan')
                                ->join('Lamaran', 'Pekerjaan.idLamaran', '=', 'Lamaran.idLamaran')
                                ->join('Lowongan', 'Lamaran.idLowongan', '=', 'Lowongan.idLowongan')
                                ->where('Lowongan.idPemberiKerja', $idPemberiKerja)
                                ->where('Pekerjaan.status_pekerjaan', 'selesai')
                                ->count(),
        ];

        // 2. Ambil Daftar Pekerjaan (untuk Slider)
        // Kita ambil pekerjaan yang sedang berjalan atau butuh review
        $pekerjaan = DB::table('Pekerjaan')
            ->join('Lamaran', 'Pekerjaan.idLamaran', '=', 'Lamaran.idLamaran')
            ->join('Lowongan', 'Lamaran.idLowongan', '=', 'Lowongan.idLowongan')
            ->join('Pekerja', 'Lamaran.idPekerja', '=', 'Pekerja.idPekerja')
            ->join('User', 'Pekerja.idUser', '=', 'User.idUser') // Ambil nama pekerja
            ->select(
                'Pekerjaan.*', 
                'Lowongan.judul', 
                'Lowongan.upah', 
                'Lowongan.lokasi',
                'User.nama as nama_pekerja'
            )
            ->where('Lowongan.idPemberiKerja', $idPemberiKerja)
            ->get();

        return view('pemberi-kerja.dashboard', compact('stats', 'pekerjaan'));
    }
    
    /**
     * Halaman Pengaturan
     */
    public function pengaturan()
    {
        return view('pemberi-kerja.pengaturan');
    }
}
