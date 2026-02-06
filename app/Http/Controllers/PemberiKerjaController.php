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

        // Hitung pekerja yang menunggu konfirmasi
        $pekerjaMenunggu = DB::table('lamaran')
            ->join('lowongan', 'lamaran.idLowongan', '=', 'lowongan.idLowongan')
            ->leftJoin('pekerjaan', 'lamaran.idLamaran', '=', 'pekerjaan.idLamaran')
            ->where('lowongan.idPemberiKerja', $idPemberiKerja)
            ->where('lamaran.status_lamaran', 'diterima')
            ->whereNull('pekerjaan.idPekerjaan')
            ->count();

        // 2. Ambil Daftar Pekerjaan (untuk Slider)
        // Kita ambil pekerjaan yang sedang berjalan atau butuh review
        $pekerjaan = DB::table('pekerjaan')
            ->join('lamaran', 'pekerjaan.idLamaran', '=', 'lamaran.idLamaran')
            ->join('lowongan', 'lamaran.idLowongan', '=', 'lowongan.idLowongan')
            ->join('pekerja', 'lamaran.idPekerja', '=', 'pekerja.idPekerja')
            ->join('user', 'pekerja.idUser', '=', 'user.idUser') // Ambil nama pekerja
            ->select(
                'pekerjaan.idPekerjaan',
                'pekerjaan.status_pekerjaan',
                'pekerjaan.tanggal_mulai',
                'pekerjaan.tanggal_selesai',
                'lowongan.idLowongan',
                'lowongan.judul', 
                'lowongan.upah', 
                'lowongan.lokasi',
                'lamaran.idLamaran',
                'user.nama as nama_pekerja'
            )
            ->where('lowongan.idPemberiKerja', $idPemberiKerja)
            ->orderBy('pekerjaan.created_at', 'desc')
            ->limit(5)
            ->get();

        // Jika tidak ada pekerjaan aktif, tampilkan lowongan aktif saja
        if ($pekerjaan->isEmpty()) {
            $pekerjaan = DB::table('lowongan')
                ->select(
                    DB::raw('NULL as idPekerjaan'),
                    DB::raw('"aktif" as status_pekerjaan'),
                    DB::raw('NULL as tanggal_mulai'),
                    DB::raw('NULL as tanggal_selesai'),
                    'idLowongan',
                    'judul', 
                    'upah', 
                    'lokasi',
                    DB::raw('NULL as idLamaran'),
                    DB::raw('"Belum ada pekerja" as nama_pekerja')
                )
                ->where('idPemberiKerja', $idPemberiKerja)
                ->where('status', 'aktif')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

        return view('pemberi-kerja.dashboard', compact('stats', 'pekerjaan', 'pekerjaMenunggu'));
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

        $idPemberiKerja = 1; // TODO: Get from auth()->user()

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
        $idPemberiKerja = 1; // TODO: Get from auth()->user()

        // Query lowongan berdasarkan pemberi kerja
        $lowongan = DB::table('lowongan')
            ->where('idPemberiKerja', $idPemberiKerja)
            ->leftJoin('lamaran', 'lowongan.idLowongan', '=', 'lamaran.idLowongan')
            ->select(
                'lowongan.idLowongan',
                'lowongan.judul',
                'lowongan.lokasi',
                'lowongan.status',
                DB::raw('COUNT(lamaran.idLamaran) as total_pelamar')
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
        $idPemberiKerja = 1; // TODO: Get from auth()->user()

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
}
