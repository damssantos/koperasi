<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'akun'     => 'required|string|email',
            'password' => 'required|string',
        ], [
            'akun.required'     => 'Kolom Email wajib diisi.',
            'akun.email'        => 'Format alamat email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        if (Auth::attempt(['email' => $credentials['akun'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect('/dashboard'); 
        }

        return back()->withErrors([
            'akun' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('akun');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'nik'          => 'required|numeric|digits:16|unique:users,nik', 
            'email'        => 'required|string|email|max:255|unique:users,email',
            'alamat'       => 'required|string|min:10',
            'no_hp'        => 'required|numeric|digits_between:10,15',
            'password'     => 'required|string|min:6',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.regex'    => 'Nama lengkap hanya boleh berisi huruf dan spasi.',
            'nik.required'          => 'NIK wajib diisi.',
            'nik.numeric'           => 'NIK hanya boleh berisi angka.',
            'nik.digits'            => 'NIK harus tepat berisi 16 digit angka.',
            'nik.unique'            => 'NIK ini sudah terdaftar di sistem koperasi.',
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.unique'          => 'Email ini sudah terdaftar.',
            'alamat.required'       => 'Alamat rumah wajib diisi.',
            'alamat.min'            => 'Mohon masukkan alamat rumah Anda dengan lebih lengkap (minimal 10 karakter).',
            'no_hp.required'        => 'Nomor handphone wajib diisi.',
            'no_hp.numeric'         => 'Nomor handphone harus berupa angka.',
            'no_hp.digits_between'  => 'Nomor handphone harus terdiri dari 10 sampai 15 digit.',
            'password.required'     => 'Kata sandi wajib diisi.',
            'password.min'          => 'Kata sandi minimal harus 6 karakter.',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap, 
            'nik'          => $request->nik,
            'email'        => $request->email,
            'alamat'       => $request->alamat,
            'no_hp'        => $request->no_hp,
            'password'     => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}