<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    /**
     * FITUR 8: Beri Rating
     * Memberikan rating untuk pekerja atau pemberi kerja
     */
    public function beriRating(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'idPekerjaan' => 'required|integer',
            'nilai_rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            // 1. Ambil data pekerjaan
            $pekerjaan = DB::table('pekerjaan')
                ->join('lamaran', 'pekerjaan.idLamaran', '=', 'lamaran.idLamaran')
                ->join('lowongan', 'lamaran.idLowongan', '=', 'lowongan.idLowongan')
                ->select(
                    'pekerjaan.*',
                    'lamaran.idPekerja',
                    'lowongan.idPemberiKerja',
                    'lowongan.judul'
                )
                ->where('pekerjaan.idPekerjaan', $validated['idPekerjaan'])
                ->first();

            if (!$pekerjaan) {
                return redirect()->back()->with('error', 'Pekerjaan tidak ditemukan');
            }

            // 2. Cek apakah pekerjaan sudah selesai
            if ($pekerjaan->status_pekerjaan !== 'selesai') {
                return redirect()->back()->with('error', 'Pekerjaan harus diselesaikan terlebih dahulu sebelum memberi rating');
            }

            // 3. Cek apakah sudah pernah memberi rating
            $existingRating = DB::table('rating')
                ->where('idPekerjaan', $validated['idPekerjaan'])
                ->first();

            if ($existingRating) {
                return redirect()->back()->with('error', 'Rating untuk pekerjaan ini sudah diberikan');
            }

            // 4. Simpan rating
            $ratingId = DB::table('rating')->insertGetId([
                'idPekerjaan' => $validated['idPekerjaan'],
                'nilai_rating' => $validated['nilai_rating'],
                'ulasan' => $validated['ulasan'] ?? null,
                'pemberi_rating' => 'pemberi_kerja',
                'created_at' => now()
            ]);

            // 5. Update status pekerjaan menjadi selesai dengan rating
            DB::table('pekerjaan')
                ->where('idPekerjaan', $validated['idPekerjaan'])
                ->update(['status_pekerjaan' => 'selesai']);

            // 6. Buat notifikasi untuk pekerja
            $pekerja = DB::table('pekerja')->where('idPekerja', $pekerjaan->idPekerja)->first();
            
            DB::table('notifikasi')->insert([
                'idUser' => $pekerja->idUser,
                'tipe_notifikasi' => 'rating',
                'pesan' => "Anda menerima rating {$validated['nilai_rating']} bintang dari pemberi kerja untuk pekerjaan '{$pekerjaan->judul}'",
                'is_read' => 0,
                'created_at' => now()
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Rating berhasil diberikan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Halaman Riwayat Rating (untuk melihat rating yang diterima)
     */
    public function index()
    {
        // Ambil ID user yang login
        // Sementara pakai dummy
        $idUser = 1;
        
        // Tentukan role user
        $user = DB::table('User')->where('idUser', $idUser)->first();
        
        if ($user->peran === 'PemberiKerja') {
            $pemberiKerja = DB::table('PemberiKerja')->where('idUser', $idUser)->first();
            
            // Rating yang diterima pemberi kerja
            $ratings = DB::table('Rating')
                ->join('Pekerjaan', 'Rating.idPekerjaan', '=', 'Pekerjaan.idPekerjaan')
                ->join('Lamaran', 'Pekerjaan.idLamaran', '=', 'Lamaran.idLamaran')
                ->join('Lowongan', 'Lamaran.idLowongan', '=', 'Lowongan.idLowongan')
                ->join('Pekerja', 'Rating.idPekerja', '=', 'Pekerja.idPekerja')
                ->join('User', 'Pekerja.idUser', '=', 'User.idUser')
                ->select(
                    'Rating.*',
                    'Lowongan.judul',
                    'User.nama as pemberi_rating'
                )
                ->where('Rating.idPemberiKerja', $pemberiKerja->idPemberiKerja)
                ->whereNull('Rating.deleted_at')
                ->orderBy('Rating.tanggal_rating', 'desc')
                ->get();
                
        } else {
            $pekerja = DB::table('Pekerja')->where('idUser', $idUser)->first();
            
            // Rating yang diterima pekerja
            $ratings = DB::table('Rating')
                ->join('Pekerjaan', 'Rating.idPekerjaan', '=', 'Pekerjaan.idPekerjaan')
                ->join('Lamaran', 'Pekerjaan.idLamaran', '=', 'Lamaran.idLamaran')
                ->join('Lowongan', 'Lamaran.idLowongan', '=', 'Lowongan.idLowongan')
                ->join('PemberiKerja', 'Rating.idPemberiKerja', '=', 'PemberiKerja.idPemberiKerja')
                ->join('User', 'PemberiKerja.idUser', '=', 'User.idUser')
                ->select(
                    'Rating.*',
                    'Lowongan.judul',
                    'User.nama as pemberi_rating'
                )
                ->where('Rating.idPekerja', $pekerja->idPekerja)
                ->whereNull('Rating.deleted_at')
                ->orderBy('Rating.tanggal_rating', 'desc')
                ->get();
        }
        
        return view('rating.index', compact('ratings'));
    }
}