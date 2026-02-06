<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
            'ulasan' => 'nullable|string|max:500',
            // Input tambahan detail - semua optional
            'kualitas' => 'nullable|integer|min:0|max:5',
            'waktu' => 'nullable|integer|min:0|max:5',
            'komunikasi' => 'nullable|integer|min:0|max:5',
            'inisiatif' => 'nullable|integer|min:0|max:5',
            'bersedia_kembali' => 'nullable|string'
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

            // 3. Cek apakah sudah pernah memberi rating sebagai PemberiKerja
            $existingRating = DB::table('rating')
                ->where('idPekerjaan', $validated['idPekerjaan'])
                ->where('pemberi_rating', 'PemberiKerja')
                ->first();

            if ($existingRating) {
                return redirect()->back()->with('error', 'Rating untuk pekerjaan ini sudah diberikan');
            }

            // Gabungkan detail penilaian ke ulasan text
            $richUlasan = $validated['ulasan'] ?? '';
            // Append detail jika ada (seperti mockup)
            if ($request->has('kualitas') || $request->has('waktu') || $request->has('komunikasi') || $request->has('inisiatif')) {
                $detailStr = [];
                $kualitas = $request->input('kualitas');
                $waktu = $request->input('waktu');
                $komunikasi = $request->input('komunikasi');
                $inisiatif = $request->input('inisiatif');
                
                if (!empty($kualitas) && $kualitas > 0) $detailStr[] = "Kualitas: {$kualitas}/5";
                if (!empty($waktu) && $waktu > 0) $detailStr[] = "Waktu: {$waktu}/5";
                if (!empty($komunikasi) && $komunikasi > 0) $detailStr[] = "Komunikasi: {$komunikasi}/5";
                if (!empty($inisiatif) && $inisiatif > 0) $detailStr[] = "Inisiatif: {$inisiatif}/5";
                
                if (!empty($detailStr)) {
                    $richUlasan .= "\n\n[Detail Penilaian]\n" . implode("\n", $detailStr);
                }
            }

            // 4. Simpan rating
            $ratingId = DB::table('rating')->insertGetId([
                'idPekerjaan' => $validated['idPekerjaan'],
                'nilai_rating' => $validated['nilai_rating'],
                'ulasan' => $richUlasan, // Simpan ulasan lengkap
                'pemberi_rating' => 'PemberiKerja', // Case sensitive match controller lain
                'created_at' => now()
            ]);

            // 5. Update status pekerjaan (tidak wajib karena sudah selesai, tapi untuk log updated_at)
            DB::table('pekerjaan')
                ->where('idPekerjaan', $validated['idPekerjaan'])
                ->update(['updated_at' => now()]);

            // 6. Buat notifikasi untuk pekerja
            $pekerja = DB::table('pekerja')->where('idPekerja', $pekerjaan->idPekerja)->first();
            
            DB::table('notifikasi')->insert([
                'idUser' => $pekerja->idUser,
                'tipe_notifikasi' => 'rating',
                'pesan' => "Anda menerima rating <strong>{$validated['nilai_rating']} bintang</strong> dari pemberi kerja untuk pekerjaan '<strong>{$pekerjaan->judul}</strong>'.",
                'is_read' => 0,
                'created_at' => now()
            ]);

            // 7. Buat notifikasi untuk pemberi kerja
            $pemberiKerja = DB::table('PemberiKerja')->where('idPemberiKerja', $pekerjaan->idPemberiKerja)->first();
            if ($pemberiKerja) {
                DB::table('notifikasi')->insert([
                    'idUser' => $pemberiKerja->idUser,
                    'tipe_notifikasi' => 'rating_dikirim',
                    'pesan' => "Rating Anda untuk '<strong>{$pekerjaan->judul}</strong>' telah terkirim kepada pekerja. Anda tidak dapat mengubah rating ini lagi.",
                    'is_read' => 0,
                    'created_at' => now()
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Rating berhasil diberikan! Pekerja sudah menerima rating Anda.');

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
        $idUser = Auth::id();
        
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