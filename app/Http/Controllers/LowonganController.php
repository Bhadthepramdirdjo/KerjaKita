<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LowonganController extends Controller
{
    /**
     * Display a listing of all lowongan (for employer)
     */
    public function index()
    {
        // Ambil ID pemberi kerja dari user yang login
        $idPemberiKerja = auth()->user()->idPemberiKerja ?? 1; // TODO: Get from authenticated user

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

        $idPemberiKerja = auth()->user()->idPemberiKerja ?? 1; // TODO: Get from authenticated user

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
        $lowongan = DB::table('lowongan')
            ->where('idLowongan', $id)
            ->first();

        if (!$lowongan) {
            return redirect()->route('pemberi-kerja.lowongan.index')
                ->with('error', 'Lowongan tidak ditemukan');
        }

        return view('pemberi-kerja.lowongan.detail', compact('lowongan'));
    }

    /**
     * Show the form for editing the specified lowongan
     */
    public function edit($id)
    {
        $lowongan = DB::table('lowongan')
            ->where('idLowongan', $id)
            ->first();

        if (!$lowongan) {
            return redirect()->route('pemberi-kerja.lowongan.index')
                ->with('error', 'Lowongan tidak ditemukan');
        }

        return view('pemberi-kerja.pekerjaan.edit-lowongan', compact('lowongan'));
    }

    /**
     * Update the specified lowongan in database
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'upah' => 'required|numeric|min:0',
            'kategori' => 'required|string|max:100',
            'status' => 'required|in:aktif,draft,selesai'
        ]);

        DB::table('lowongan')
            ->where('idLowongan', $id)
            ->update([
                'judul' => $validated['judul'],
                'deskripsi' => $validated['deskripsi'],
                'lokasi' => $validated['lokasi'],
                'upah' => $validated['upah'],
                'kategori' => $validated['kategori'],
                'status' => $validated['status'],
                'updated_at' => now()
            ]);

        return redirect()
            ->route('pemberi-kerja.lowongan-saya')
            ->with('success', 'Lowongan berhasil diperbarui');
    }
}

