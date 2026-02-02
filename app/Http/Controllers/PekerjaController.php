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
     * Halaman Pengaturan
     */
    public function pengaturan()
    {
        return view('pekerja.pengaturan');
    }
}
