<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan halaman login untuk admin
    public function loginPage()
    {
        return view('auth.login');
    }

    // Proses autentikasi login untuk admin melalui website
    public function login(Request $request)
    {
        // Validasi input dari form login
        $request->validate([
            'telepon' => 'required', // Telepon wajib diisi
            'password' => 'required|min:6', // Password minimal 6 karakter
        ]);

        // Melakukan autentikasi berdasarkan nomor telepon dan password
        if (Auth::attempt(['telepon' => $request->telepon, 'password' => $request->password])) {
            $user = Auth::user(); // Mengambil data user yang berhasil login

            // Jika user memiliki peran sebagai admin, arahkan ke dashboard
            if ($user->role === 'admin') {
                return redirect()->route('dashboard');
            }

            // Jika bukan admin, logout dan tampilkan pesan error
            Auth::logout();
            return back()->withErrors([
                'telepon' => 'Anda tidak memiliki akses sebagai admin.',
            ]);
        }

        // Jika login gagal, kembalikan ke halaman login dengan pesan error
        return back()->withErrors([
            'telepon' => 'Telepon atau password yang Anda masukkan salah.',
        ]);
    }

    // Proses autentikasi login untuk aplikasi mobile (Petugas & Pelanggan)
    public function loginMobile(Request $request)
    {
        // Validasi input dari mobile
        $validated = $request->validate([
            'telepon' => 'required|numeric', // Telepon harus berupa angka dan wajib diisi
            'password' => 'required|string', // Password wajib diisi
        ]);

        // Mencari user berdasarkan nomor telepon
        $user = User::where('telepon', $request->telepon)->first();

        // Jika user tidak ditemukan atau password salah, kirimkan respons error
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Kredensial tidak valid'], 401);
        }

        // Jika user adalah admin, tolak login dari aplikasi mobile
        if ($user->role === 'admin') {
            return response()->json(['error' => 'Admin tidak dapat login melalui aplikasi ini'], 403);
        }

        // Jika berhasil, buat token untuk autentikasi mobile
        $token = $user->createToken('auth_token')->plainTextToken;

        // Kirimkan respons sukses dengan data user dan token
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'token' => $token,
        ]);
    }

    // Logout untuk aplikasi mobile
    public function logout(Request $request)
    {
        // Menghapus semua token milik user yang sedang login
        Auth::user()->tokens->each(function ($token) {
            $token->delete();
        });

        // Kirimkan respons logout berhasil
        return response()->json(['message' => 'Logged out successfully']);
    }
}