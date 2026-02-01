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

        // Cek user di database
        $user = DB::table('User')
            ->where('username', $request->username)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors(['username' => 'Username atau password salah'])
                ->withInput();
        }

        // Simpan user ke session
        session([
            'user_id' => $user->idUser,
            'username' => $user->username,
            'nama' => $user->nama,
            'email' => $user->email,
            'tipe' => $user->tipe_user
        ]);

        return redirect('/')->with('success', 'Login berhasil!');
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
            'username' => 'required|string|max:100|unique:User,username',
            'email' => 'required|email|max:255|unique:User,email',
            'password' => 'required|string|min:6|confirmed',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tipe_user' => 'required|in:Pekerja,PemberiKerja'
        ], [
            'username.unique' => 'Username sudah terdaftar',
            'email.unique' => 'Email sudah terdaftar',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok'
        ]);

        // Insert ke database
        $userId = DB::table('User')->insertGetId([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'jenis_kelamin' => $request->jenis_kelamin,
            'tipe_user' => $request->tipe_user,
            'alamat' => $request->alamat ?? '',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Jika pemberi kerja, buat record di tabel PemberiKerja
        if ($request->tipe_user === 'PemberiKerja') {
            DB::table('PemberiKerja')->insert([
                'idUser' => $userId,
                'nama_perusahaan' => $request->nama,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Jika pekerja, buat record di tabel Pekerja
        if ($request->tipe_user === 'Pekerja') {
            DB::table('Pekerja')->insert([
                'idUser' => $userId,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return redirect()->route('login')
            ->with('success', 'Pendaftaran berhasil! Silakan login dengan akun Anda.');
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
