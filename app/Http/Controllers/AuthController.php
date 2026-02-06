<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke dashboard
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }

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

        // Attempt login menggunakan Laravel Auth
        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Log activity
            DB::table('activity_log')->insert([
                'idUser' => Auth::id(),
                'activity_type' => 'login',
                'description' => 'User login ke sistem',
                'ip_address' => $request->ip(),
                'created_at' => now()
            ]);

            return redirect()->intended($this->redirectPath())
                ->with('success', 'Login berhasil! Selamat datang, ' . Auth::user()->nama);
        }

        // Log failed login attempt
        DB::table('activity_log')->insert([
            'idUser' => null,
            'activity_type' => 'login_failed',
            'description' => 'Gagal login dengan username: ' . $request->username,
            'ip_address' => $request->ip(),
            'created_at' => now()
        ]);

        return back()
            ->withErrors(['username' => 'Username atau password salah'])
            ->withInput($request->only('username'));
    }

    /**
     * Tampilkan halaman register
     */
    public function showRegisterForm()
    {
        // Jika sudah login, redirect ke dashboard
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }

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
            'tipe_user' => 'required|in:Pekerja,PemberiKerja',
            'alamat' => 'nullable|string|max:500',
            'no_hp' => 'nullable|string|max:20',
        ], [
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
            'tipe_user.required' => 'Tipe user harus dipilih',
        ]);

      try {
            DB::beginTransaction();

            $user = User::create([
                'nama' => $request->nama,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'jenis_kelamin' => $request->jenis_kelamin,
                'tipe_user' => $request->tipe_user,
                'alamat' => $request->alamat ?? '',
                'no_hp' => $request->no_hp ?? '',
            ]);

            if ($request->tipe_user === 'PemberiKerja') {
                $exists = DB::table('PemberiKerja')->where('idUser', $user->idUser)->exists();
                if (!$exists) {
                    DB::table('PemberiKerja')->insert([
                        'idUser' => $user->idUser,
                        'nama_perusahaan' => $request->nama,
                        'alamat' => $request->alamat ?? '',
                        'no_telp' => $request->no_hp ?? '',
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            } elseif ($request->tipe_user === 'Pekerja') {
                $exists = DB::table('Pekerja')->where('idUser', $user->idUser)->exists();
                if (!$exists) {
                    DB::table('Pekerja')->insert([
                        'idUser' => $user->idUser,
                        'alamat' => $request->alamat ?? '',
                        'no_telp' => $request->no_hp ?? '',
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            DB::table('activity_log')->insert([
                'idUser' => $user->idUser,
                'activity_type' => 'register',
                'description' => 'User baru mendaftar sebagai ' . $request->tipe_user,
                'ip_address' => $request->ip(),
                'created_at' => now()
            ]);

            DB::commit();

            return redirect()->route('login')
                ->with('success', 'Pendaftaran berhasil! Silakan login dengan akun Anda.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Registration failed: ' . $e->getMessage());
            return back()
                ->withErrors(['error' => 'Terjadi kesalahan saat mendaftar: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        // Log activity sebelum logout
        if (Auth::check()) {
            DB::table('activity_log')->insert([
                'idUser' => Auth::id(),
                'activity_type' => 'logout',
                'description' => 'User logout dari sistem',
                'ip_address' => $request->ip(),
                'created_at' => now()
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Logout berhasil');
    }

    /**
     * Helper: Redirect path setelah login
     */
    protected function redirectPath()
    {
        if (Auth::user()->isPemberiKerja()) {
            return route('pemberi-kerja.dashboard');
        }

        return route('pekerja.dashboard');
    }

    /**
     * Helper: Redirect ke dashboard sesuai role
     */
    protected function redirectToDashboard()
    {
        if (Auth::user()->isPemberiKerja()) {
            return redirect()->route('pemberi-kerja.dashboard');
        }

        return redirect()->route('pekerja.dashboard');
    }
}
