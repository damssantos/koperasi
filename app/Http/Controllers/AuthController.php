<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\OtpVerification;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'akun' => 'required|string|email',
            'password' => 'required|string',
        ], [
            'akun.required' => 'Kolom Email wajib diisi.',
            'akun.email' => 'Format alamat email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $user = User::where('email', $credentials['akun'])->first();

        /*
        |--------------------------------------------------------------------------
        | CEK EMAIL SUDAH DIVERIFIKASI
        |--------------------------------------------------------------------------
        */

        if ($user && is_null($user->email_verified_at)) {
            return back()
                ->withErrors([
                    'akun' => 'Email Anda belum diverifikasi. Silakan verifikasi OTP terlebih dahulu.',
                ])
                ->onlyInput('akun');
        }

        /*
        |--------------------------------------------------------------------------
        | LOGIN
        |--------------------------------------------------------------------------
        */

        if (
            Auth::attempt([
                'email' => $credentials['akun'],
                'password' => $credentials['password'],
            ])
        ) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect('/dashboard');
            }

            if ($user->role === 'pengawas') {
                return redirect('/pengawas');
            }

            return redirect('/customer/dashboard');
        }

        return back()
            ->withErrors([
                'akun' => 'Email atau kata sandi yang Anda masukkan salah.',
            ])
            ->onlyInput('akun');
    }


    /*
    |--------------------------------------------------------------------------
    | REGISTER
    |--------------------------------------------------------------------------
    */

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI DATA REGISTER
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'nama_lengkap' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'nik' => 'required|numeric|digits:16|unique:users,nik',
            'email' => 'required|string|email|max:255|unique:users,email',
            'alamat' => 'required|string|min:10',
            'no_hp' => 'required|numeric|digits_between:10,15',
            'password' => 'required|string|min:6',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.regex' => 'Nama lengkap hanya boleh berisi huruf dan spasi.',

            'nik.required' => 'NIK wajib diisi.',
            'nik.numeric' => 'NIK hanya boleh berisi angka.',
            'nik.digits' => 'NIK harus tepat berisi 16 digit angka.',
            'nik.unique' => 'NIK ini sudah terdaftar di sistem koperasi.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar.',

            'alamat.required' => 'Alamat rumah wajib diisi.',
            'alamat.min' => 'Mohon masukkan alamat rumah Anda dengan lebih lengkap (minimal 10 karakter).',

            'no_hp.required' => 'Nomor handphone wajib diisi.',
            'no_hp.numeric' => 'Nomor handphone harus berupa angka.',
            'no_hp.digits_between' => 'Nomor handphone harus terdiri dari 10 sampai 15 digit.',

            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal harus 6 karakter.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | BUAT USER
        |--------------------------------------------------------------------------
        */

        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'email_verified_at' => null,
            'role' => 'customer',
        ]);

        /*
        |--------------------------------------------------------------------------
        | HAPUS OTP REGISTER SEBELUMNYA
        |--------------------------------------------------------------------------
        */

        OtpVerification::where('email', $user->email)
            ->where('type', 'register')
            ->delete();

        /*
        |--------------------------------------------------------------------------
        | GENERATE OTP
        |--------------------------------------------------------------------------
        */

        $otp = (string) random_int(100000, 999999);

        /*
        |--------------------------------------------------------------------------
        | SIMPAN OTP DALAM DATABASE
        |--------------------------------------------------------------------------
        */

        OtpVerification::create([
            'email' => $user->email,
            'code' => Hash::make($otp),
            'type' => 'register',
            'expires_at' => now()->addMinutes(5),
            'attempts' => 0,
        ]);

        /*
        |--------------------------------------------------------------------------
        | SIMPAN EMAIL REGISTER KE SESSION
        |--------------------------------------------------------------------------
        */

        session([
            'register_email' => $user->email,
        ]);

        /*
        |--------------------------------------------------------------------------
        | KIRIM OTP KE EMAIL
        |--------------------------------------------------------------------------
        */

        Mail::to($user->email)->send(
            new OtpMail($otp, 'register')
        );

        /*
        |--------------------------------------------------------------------------
        | KE HALAMAN OTP
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('register.verify')
            ->with(
                'success',
                'Registrasi berhasil. Kode OTP telah dikirim ke email Anda.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | HALAMAN OTP REGISTER
    |--------------------------------------------------------------------------
    */

    public function showRegisterOtp()
    {
        $email = session('register_email');

        if (!$email) {
            return redirect()
                ->route('register')
                ->with(
                    'error',
                    'Silakan lakukan registrasi terlebih dahulu.'
                );
        }

        return view(
            'auth.verify-otp',
            compact('email')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | VERIFIKASI OTP REGISTER
    |--------------------------------------------------------------------------
    */

    public function verifyRegisterOtp(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI OTP
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'otp' => 'required|digits:6',
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.digits' => 'Kode OTP harus terdiri dari 6 digit.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | AMBIL EMAIL DARI SESSION
        |--------------------------------------------------------------------------
        */

        $email = session('register_email');

        if (!$email) {
            return redirect()
                ->route('register')
                ->with(
                    'error',
                    'Sesi registrasi sudah berakhir. Silakan registrasi kembali.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | CARI OTP
        |--------------------------------------------------------------------------
        */

        $verification = OtpVerification::where('email', $email)
            ->where('type', 'register')
            ->first();

        if (!$verification) {
            return back()
                ->withErrors([
                    'otp' => 'Kode OTP tidak ditemukan. Silakan kirim ulang OTP.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | CEK EXPIRED
        |--------------------------------------------------------------------------
        */

        if ($verification->expires_at->isPast()) {
            $verification->delete();

            return back()
                ->withErrors([
                    'otp' => 'Kode OTP sudah kedaluwarsa. Silakan kirim ulang OTP.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | CEK OTP
        |--------------------------------------------------------------------------
        */

        if (!Hash::check($request->otp, $verification->code)) {

            $verification->increment('attempts');

            return back()
                ->withErrors([
                    'otp' => 'Kode OTP yang Anda masukkan salah.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | CARI USER
        |--------------------------------------------------------------------------
        */

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()
                ->route('register')
                ->with(
                    'error',
                    'Akun tidak ditemukan. Silakan registrasi kembali.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | VERIFIKASI EMAIL
        |--------------------------------------------------------------------------
        */

        $user->update([
            'email_verified_at' => now(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | HAPUS OTP
        |--------------------------------------------------------------------------
        */

        $verification->delete();

        /*
        |--------------------------------------------------------------------------
        | HAPUS SESSION REGISTER
        |--------------------------------------------------------------------------
        */

        session()->forget([
            'register_email',
        ]);

        /*
        |--------------------------------------------------------------------------
        | KEMBALI KE LOGIN
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Email berhasil diverifikasi. Silakan login dengan akun Anda.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | KIRIM ULANG OTP REGISTER
    |--------------------------------------------------------------------------
    */

    public function resendRegisterOtp()
    {
        $email = session('register_email');

        if (!$email) {
            return redirect()
                ->route('register')
                ->with(
                    'error',
                    'Sesi registrasi sudah berakhir. Silakan registrasi kembali.'
                );
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()
                ->route('register')
                ->with(
                    'error',
                    'Akun tidak ditemukan. Silakan registrasi kembali.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | HAPUS OTP LAMA
        |--------------------------------------------------------------------------
        */

        OtpVerification::where('email', $email)
            ->where('type', 'register')
            ->delete();

        /*
        |--------------------------------------------------------------------------
        | BUAT OTP BARU
        |--------------------------------------------------------------------------
        */

        $otp = (string) random_int(100000, 999999);

        /*
        |--------------------------------------------------------------------------
        | SIMPAN OTP BARU
        |--------------------------------------------------------------------------
        */

        OtpVerification::create([
            'email' => $email,
            'code' => Hash::make($otp),
            'type' => 'register',
            'expires_at' => now()->addMinutes(5),
            'attempts' => 0,
        ]);

        /*
        |--------------------------------------------------------------------------
        | KIRIM ULANG EMAIL
        |--------------------------------------------------------------------------
        */

        Mail::to($email)->send(
            new OtpMail($otp, 'register')
        );

        return back()
            ->with(
                'success',
                'Kode OTP baru berhasil dikirim ke email Anda.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | LUPA PASSWORD
    |--------------------------------------------------------------------------
    */

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }


    /*
    |--------------------------------------------------------------------------
    | KIRIM OTP RESET PASSWORD
    |--------------------------------------------------------------------------
    */

    public function sendResetOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $email = $request->email;

        /*
        |--------------------------------------------------------------------------
        | CEK USER
        |--------------------------------------------------------------------------
        */

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()
                ->withErrors([
                    'email' => 'Email tidak ditemukan dalam sistem.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | HAPUS OTP RESET SEBELUMNYA
        |--------------------------------------------------------------------------
        */

        OtpVerification::where('email', $email)
            ->where('type', 'reset')
            ->delete();

        /*
        |--------------------------------------------------------------------------
        | BUAT OTP
        |--------------------------------------------------------------------------
        */

        $otp = (string) random_int(100000, 999999);

        /*
        |--------------------------------------------------------------------------
        | SIMPAN OTP
        |--------------------------------------------------------------------------
        */

        OtpVerification::create([
            'email' => $email,
            'code' => Hash::make($otp),
            'type' => 'reset',
            'expires_at' => now()->addMinutes(5),
            'attempts' => 0,
        ]);

        /*
        |--------------------------------------------------------------------------
        | SIMPAN EMAIL KE SESSION
        |--------------------------------------------------------------------------
        */

        session([
            'reset_password_email' => $email,
        ]);

        /*
        |--------------------------------------------------------------------------
        | KIRIM OTP
        |--------------------------------------------------------------------------
        */

        Mail::to($email)->send(
            new OtpMail($otp, 'reset')
        );

        /*
        |--------------------------------------------------------------------------
        | KE HALAMAN OTP RESET
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('password.verify')
            ->with(
                'success',
                'Kode OTP berhasil dikirim ke email Anda.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | HALAMAN OTP RESET PASSWORD
    |--------------------------------------------------------------------------
    */

    public function showResetOtp()
    {
        $email = session('reset_password_email');

        if (!$email) {
            return redirect()
                ->route('password.request')
                ->with(
                    'error',
                    'Silakan masukkan email terlebih dahulu.'
                );
        }

        return view(
            'auth.reset-otp',
            compact('email')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | VERIFIKASI OTP RESET PASSWORD
    |--------------------------------------------------------------------------
    */

    public function verifyResetOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.digits' => 'Kode OTP harus terdiri dari 6 digit.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | AMBIL EMAIL
        |--------------------------------------------------------------------------
        */

        $email = session('reset_password_email');

        if (!$email) {
            return redirect()
                ->route('password.request')
                ->with(
                    'error',
                    'Sesi reset password sudah berakhir. Silakan masukkan email kembali.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | CARI OTP
        |--------------------------------------------------------------------------
        */

        $verification = OtpVerification::where('email', $email)
            ->where('type', 'reset')
            ->first();

        if (!$verification) {
            return back()
                ->withErrors([
                    'otp' => 'Kode OTP tidak ditemukan. Silakan kirim ulang OTP.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | CEK EXPIRED
        |--------------------------------------------------------------------------
        */

        if ($verification->expires_at->isPast()) {
            $verification->delete();

            return back()
                ->withErrors([
                    'otp' => 'Kode OTP sudah kedaluwarsa. Silakan kirim ulang OTP.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | CEK OTP
        |--------------------------------------------------------------------------
        */

        if (!Hash::check($request->otp, $verification->code)) {

            $verification->increment('attempts');

            return back()
                ->withErrors([
                    'otp' => 'Kode OTP yang Anda masukkan salah.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | OTP BENAR
        |--------------------------------------------------------------------------
        */

        $verification->delete();

        /*
        |--------------------------------------------------------------------------
        | SIMPAN STATUS RESET PASSWORD
        |--------------------------------------------------------------------------
        */

        session([
            'password_reset_email' => $email,
            'password_reset_verified' => true,
        ]);

        /*
        |--------------------------------------------------------------------------
        | KE HALAMAN PASSWORD BARU
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('password.reset');
    }


    /*
    |--------------------------------------------------------------------------
    | HALAMAN RESET PASSWORD
    |--------------------------------------------------------------------------
    */

    public function showResetPassword()
    {
        if (
            !session('password_reset_verified') ||
            !session('password_reset_email')
        ) {
            return redirect()
                ->route('password.request');
        }

        return view('auth.reset-password');
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN PASSWORD BARU
    |--------------------------------------------------------------------------
    */

    public function resetPassword(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | CEK SESSION
        |--------------------------------------------------------------------------
        */

        if (
            !session('password_reset_verified') ||
            !session('password_reset_email')
        ) {
            return redirect()
                ->route('password.request');
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDASI PASSWORD
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | CARI USER
        |--------------------------------------------------------------------------
        */

        $email = session('password_reset_email');

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()
                ->route('password.request')
                ->with(
                    'error',
                    'Akun tidak ditemukan.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE PASSWORD
        |--------------------------------------------------------------------------
        */

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        /*
        |--------------------------------------------------------------------------
        | HAPUS SESSION RESET PASSWORD
        |--------------------------------------------------------------------------
        */

        session()->forget([
            'reset_password_email',
            'password_reset_email',
            'password_reset_verified',
            'email',
        ]);

        /*
        |--------------------------------------------------------------------------
        | KEMBALI KE LOGIN
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Password berhasil diubah. Silakan login dengan password baru.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('login');
    }
}