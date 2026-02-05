<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LowonganController extends Controller
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
     * Display a listing of all lowongan (for employer)
     */
    public function index()
    {
        // Ambil ID pemberi kerja dari user yang login
        $idPemberiKerja = $this->getIdPemberiKerja();

        $lowongan = DB::table('lowongan')
            ->where('idPemberiKerja', $idPemberiKerja)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pemberi-kerja.lowongan-saya', compact('lowongan'));
    }

    /**
     * Show the form for creating a new lowongan
     */
    public function create()
    {
        return view('pemberi-kerja.pekerjaan.buat-lowongan');
    }

    /**
     * Store a newly created lowongan in database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'upah' => 'required|numeric|min:0',
            'kategori' => 'required|string|max:100',
        ]);

        $idPemberiKerja = $this->getIdPemberiKerja();

        DB::table('lowongan')->insert([
            'idPemberiKerja' => $idPemberiKerja,
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'lokasi' => $validated['lokasi'],
            'upah' => $validated['upah'],
            'kategori' => $validated['kategori'],
            'status' => 'aktif',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()
            ->route('pemberi-kerja.lowongan.index')
            ->with('success', 'Lowongan berhasil dibuat');
    }

    /**
     * Display the specified lowongan
     */
    public function show($id)
    {
        $idPemberiKerja = $this->getIdPemberiKerja();
        
        $lowongan = DB::table('lowongan')
            ->where('idLowongan', $id)
            ->where('idPemberiKerja', $idPemberiKerja)
            ->first();

        if (!$lowongan) {
            abort(403, 'Anda tidak memiliki akses ke lowongan ini');
        }

        return view('pemberi-kerja.lowongan.detail', compact('lowongan'));
    }

    /**
     * Show the form for editing the specified lowongan
     */
    public function edit($id)
    {
        $idPemberiKerja = $this->getIdPemberiKerja();
        
        $lowongan = DB::table('lowongan')
            ->where('idLowongan', $id)
            ->where('idPemberiKerja', $idPemberiKerja)
            ->first();

        if (!$lowongan) {
            abort(403, 'Anda tidak memiliki akses ke lowongan ini');
        }

        return view('pemberi-kerja.lowongan.edit-lowongan', compact('lowongan'));
    }

    /**
     * Update the specified lowongan in database
     */
    public function update(Request $request, $id)
    {
        $idPemberiKerja = $this->getIdPemberiKerja();
        
        // Verifikasi ownership
        $lowongan = DB::table('lowongan')
            ->where('idLowongan', $id)
            ->where('idPemberiKerja', $idPemberiKerja)
            ->first();
        
        if (!$lowongan) {
            abort(403, 'Anda tidak memiliki akses ke lowongan ini');
        }
        
        // Sanitasi format upah (hapus titik)
        if ($request->has('upah')) {
            $request->merge([
                'upah' => str_replace('.', '', $request->upah)
            ]);
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'upah' => 'required|numeric|min:0',
            'kategori' => 'required', // Bisa ID atau string ID
            'status' => 'required|in:aktif,draft,selesai'
        ]);

        DB::table('lowongan')
            ->where('idLowongan', $id)
            ->update([
                'judul' => $validated['judul'],
                'deskripsi' => $validated['deskripsi'],
                'lokasi' => $validated['lokasi'],
                'upah' => $validated['upah'],
                // kategori dihapus dari sini karena beda tabel
                'status' => $validated['status'],
                'updated_at' => now()
            ]);

        // Update kategori di tabel relasi
        $exists_kat = DB::table('lowongan_kategori')->where('idLowongan', $id)->exists();
        
        if ($exists_kat) {
            DB::table('lowongan_kategori')
                ->where('idLowongan', $id)
                ->update(['id_kategori' => $validated['kategori']]);
        } else {
            DB::table('lowongan_kategori')->insert([
                'idLowongan' => $id,
                'id_kategori' => $validated['kategori']
            ]);
        }

        return redirect()
            ->route('pemberi-kerja.lowongan-saya')
            ->with('success', 'Lowongan berhasil diperbarui');
    }
}

