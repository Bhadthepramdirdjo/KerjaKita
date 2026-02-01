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
        
        $lowongan = DB::table('Lowongan')
            ->where('status', 'aktif')
            ->get();

        return view('pekerja.dashboard', compact('lowongan'));
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
        // Placeholder
        return "Detail lowongan " . $id;
    }
}
