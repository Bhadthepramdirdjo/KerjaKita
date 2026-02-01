<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * HomeController - FIXED VERSION
 *
 * Controller untuk menangani halaman-halaman publik
 * Bug Fix: Removed 'icon' column yang tidak ada di database
 */
class HomeController extends Controller
{
    /**
     * Menampilkan Landing Page (Homepage)
     *
     * Route: GET /
     * View: resources/views/welcome.blade.php
     */
    public function index()
    {
        // Ambil statistik untuk ditampilkan di hero section
        $stats = [
            'total_pekerja' => DB::table('Pekerja')->count(),
            'total_lowongan' => DB::table('Lowongan')->where('status', 'aktif')->count(),
            'total_pemberi_kerja' => DB::table('PemberiKerja')->count(),
            'total_lamaran' => DB::table('Lamaran')->count(),
        ];

        // Ambil kategori pekerjaan untuk section kategori
        // FIX: Removed 'icon' column karena tidak ada di tabel Kategori
        $categories = DB::table('Kategori')
            ->select('id_kategori', 'nama_kategori', 'deskripsi')
            ->get();

        // Ambil lowongan terbaru untuk ditampilkan (opsional)
        $featured_jobs = DB::table('Lowongan')
            ->join('PemberiKerja', 'Lowongan.idPemberiKerja', '=', 'PemberiKerja.idPemberiKerja')
            ->join('User', 'PemberiKerja.idUser', '=', 'User.idUser')
            ->select(
                'Lowongan.idLowongan',
                'Lowongan.judul',
                'Lowongan.deskripsi',
                'Lowongan.lokasi',
                'Lowongan.upah',
                'Lowongan.status',
                'PemberiKerja.nama_perusahaan',
                'User.nama as nama_pemberi_kerja'
            )
            ->where('Lowongan.status', 'aktif')
            ->orderBy('Lowongan.created_at', 'desc')
            ->limit(6)
            ->get();

        // Return view dengan data
        return view('welcome', compact('stats', 'categories', 'featured_jobs'));
    }

    /**
     * Menampilkan Halaman Tentang Kami
     */
    public function tentang()
    {
        return view('tentang');
    }

    /**
     * Menampilkan Halaman Kontak
     */
    public function kontak()
    {
        return view('kontak');
    }

    /**
     * Proses Form Kontak
     */
    public function kirimKontak(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'email' => 'required|email',
            'subjek' => 'required|max:255',
            'pesan' => 'required'
        ]);

        // TODO: Implementasi logic kirim email atau simpan ke database

        return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim!');
    }

    /**
     * Menampilkan Halaman FAQ
     */
    public function faq()
    {
        $faqs = [
            [
                'pertanyaan' => 'Bagaimana cara mendaftar di KerjaKita?',
                'jawaban' => 'Klik tombol "Daftar Sekarang" di halaman utama, lalu isi formulir pendaftaran dengan lengkap.'
            ],
            [
                'pertanyaan' => 'Apakah KerjaKita gratis?',
                'jawaban' => 'Ya, KerjaKita 100% gratis untuk pekerja dan pemberi kerja.'
            ],
            [
                'pertanyaan' => 'Bagaimana cara melamar pekerjaan?',
                'jawaban' => 'Setelah login, cari lowongan yang sesuai, klik detail, lalu klik tombol "Lamar Sekarang".'
            ],
        ];

        return view('faq', compact('faqs'));
    }

    /**
     * Menampilkan Kebijakan Privasi
     */
    public function kebijakanPrivasi()
    {
        return view('kebijakan-privasi');
    }

    /**
     * Menampilkan Syarat & Ketentuan
     */
    public function syaratKetentuan()
    {
        return view('syarat-ketentuan');
    }
}
