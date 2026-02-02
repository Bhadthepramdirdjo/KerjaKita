<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ], [
            'username.required' => 'Username harus diisi',
            'password.required' => 'Password harus diisi'
        ]);

        // Cek user di database - gunakan email sebagai login identifier
        $user = DB::table('user')
            ->where('email', $request->username)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors(['username' => 'Email atau password salah'])
                ->withInput();
        }

        // Simpan user ke session
        session([
            'user_id' => $user->idUser,
            'username' => $user->email,
            'nama' => $user->nama,
            'email' => $user->email,
            'tipe' => $user->peran
        ]);

        // Redirect ke dashboard sesuai tipe user
        if ($user->peran === 'PemberiKerja') {
            return redirect('/pemberi-kerja/dashboard')->with('success', 'Login berhasil!');
        } else {
            return redirect('/pekerja/dashboard')->with('success', 'Login berhasil!');
        }
    }

    /**
     * Tampilkan halaman register
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Proses register
     */
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:user,email',
            'password' => 'required|string|min:6|confirmed',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tipe_user' => 'required|in:Pekerja,PemberiKerja'
        ], [
            'email.unique' => 'Email sudah terdaftar',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok'
        ]);

        // Insert ke database - gunakan kolom yang benar: peran (bukan tipe_user)
        $userId = DB::table('user')->insertGetId([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'peran' => $request->tipe_user,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Trigger akan membuat record di tabel PemberiKerja atau Pekerja otomatis

        // Redirect ke dashboard sesuai tipe user
        if ($request->tipe_user === 'PemberiKerja') {
            return redirect('/pemberi-kerja/dashboard')
                ->with('success', 'Pendaftaran berhasil! Selamat datang di KerjaKita.');
        } else {
            return redirect('/pekerja/dashboard')
                ->with('success', 'Pendaftaran berhasil! Selamat datang di KerjaKita.');
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        session()->forget(['user_id', 'username', 'nama', 'email', 'tipe']);
        return redirect('/')->with('success', 'Logout berhasil');
    }
}
