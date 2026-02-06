<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EnsurePemberiKerjaAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Pastikan user adalah pemberi kerja
        $user = Auth::user();
        if ($user->tipe_user !== 'PemberiKerja' && $user->peran !== 'PemberiKerja') {
            abort(403, 'Hanya pemberi kerja yang bisa akses halaman ini');
        }

        // Pastikan user punya entry di PemberiKerja table
        $pemberiKerja = DB::table('PemberiKerja')->where('idUser', $user->idUser)->first();
        if (!$pemberiKerja) {
            // Auto-create jika belum ada
            DB::table('PemberiKerja')->insert([
                'idUser' => $user->idUser,
                'nama_perusahaan' => $user->nama,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return $next($request);
    }
}
