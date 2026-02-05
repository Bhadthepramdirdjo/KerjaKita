<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PekerjaanController extends Controller
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
     * FITUR 7: Konfirmasi Pekerjaan Selesai
     * Mengubah status pekerjaan menjadi 'selesai'
     */
    public function konfirmasiSelesai(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            // 1. Langsung update status menjadi 'selesai'
            $affected = DB::table('pekerjaan')
                ->where('idPekerjaan', $id)
                ->update([
                    'status_pekerjaan' => 'selesai',
                    'tanggal_selesai' => now(),
                    'updated_at' => now()
                ]);

            if ($affected === 0) {
                // Cek apakah ID ada tapi status sudah selesai, atau ID memang tidak ada
                $check = DB::table('pekerjaan')->where('idPekerjaan', $id)->first();
                if (!$check) {
                    return redirect()->back()->with('error', 'Pekerjaan tidak ditemukan (ID: ' . $id . ')');
                }
                if ($check->status_pekerjaan === 'selesai') {
                     return redirect()->back()->with('success', 'Pekerjaan sudah berstatus selesai.');
                }
                // Fallback catch all
                return redirect()->back()->with('error', 'Gagal mengupdate status pekerjaan.');
            }

            // 2. Ambil data untuk notifikasi (setelah update sukses)
            $pekerjaanInfo = DB::table('pekerjaan')
                ->join('lamaran', 'pekerjaan.idLamaran', '=', 'lamaran.idLamaran')
                ->join('lowongan', 'lamaran.idLowongan', '=', 'lowongan.idLowongan')
                ->join('pekerja', 'lamaran.idPekerja', '=', 'pekerja.idPekerja')
                ->select(
                    'lowongan.judul as judul_lowongan',
                    'pekerja.idUser as idUserPekerja'
                )
                ->where('pekerjaan.idPekerjaan', $id)
                ->first();

            // 3. Buat notifikasi untuk pekerja
            if ($pekerjaanInfo) {
                DB::table('notifikasi')->insert([
                    'idUser' => $pekerjaanInfo->idUserPekerja,
                    'pesan' => "Pekerjaan '<strong>{$pekerjaanInfo->judul_lowongan}</strong>' telah dikonfirmasi selesai. Anda mendapatkan rating!",
                    'tipe_notifikasi' => 'info',
                    'is_read' => false,
                    'created_at' => now()
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Pekerjaan berhasil dikonfirmasi selesai!');

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
        $idPemberiKerja = $this->getIdPemberiKerja();

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
        $idPemberiKerja = $this->getIdPemberiKerja();
        
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
            ->where('lowongan.idPemberiKerja', $idPemberiKerja)
            ->first();

        if (!$pekerjaan) {
            abort(403, 'Anda tidak memiliki akses ke pekerjaan ini');
        }

        // Cek apakah sudah ada rating
        $rating = DB::table('rating')
            ->where('idPekerjaan', $id)
            ->where('pemberi_rating', 'PemberiKerja')
            ->first();

        return view('pemberi-kerja.pekerjaan.detail', compact('pekerjaan', 'rating'));
    }
}