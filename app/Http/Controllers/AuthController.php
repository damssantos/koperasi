<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\OtpMail;
use App\Models\OtpVerification;
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
        | Cek Email Sudah Diverifikasi
        |--------------------------------------------------------------------------
        */

        if ($user && is_null($user->email_verified_at)) {
            return back()->withErrors([
                'akun' => 'Email Anda belum diverifikasi. Silakan verifikasi OTP terlebih dahulu.',
            ])->onlyInput('akun');
        }

        /*
        |--------------------------------------------------------------------------
        | Login
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

        return back()->withErrors([
            'akun' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('akun');
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
        | Buat User
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
        | Hapus OTP Register Lama
        |--------------------------------------------------------------------------
        */

        OtpVerification::where('email', $user->email)
            ->where('type', 'register')
            ->delete();

        /*
        |--------------------------------------------------------------------------
        | Generate OTP 6 Digit
        |--------------------------------------------------------------------------
        */

        $otp = (string) random_int(100000, 999999);

        /*
        |--------------------------------------------------------------------------
        | Simpan OTP ke Database
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
        | Kirim OTP ke Email
        |--------------------------------------------------------------------------
        */

        Mail::to($user->email)->send(
            new OtpMail($otp, 'register')
        );

        /*
        |--------------------------------------------------------------------------
        | Simpan Data OTP ke Session
        |--------------------------------------------------------------------------
        */

        session([
            'otp_email' => $user->email,
            'otp_type' => 'register',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Redirect ke Halaman Verifikasi OTP
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
    | VERIFIKASI OTP REGISTER
    |--------------------------------------------------------------------------
    */

    public function showVerifyOtp()
    {
        if (!session()->has('otp_email')) {
            return redirect()
                ->route('register')
                ->with(
                    'error',
                    'Silakan lakukan registrasi terlebih dahulu.'
                );
        }

        return view('auth.verify-otp', [
            'email' => session('otp_email'),
        ]);
    }


    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.digits' => 'Kode OTP harus terdiri dari 6 digit.',
        ]);

        $email = session('otp_email');

        if (!$email) {
            return redirect()
                ->route('register')
                ->with(
                    'error',
                    'Sesi verifikasi telah berakhir. Silakan registrasi kembali.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil OTP Terbaru
        |--------------------------------------------------------------------------
        */

        $otpRecord = OtpVerification::where('email', $email)
            ->where('type', 'register')
            ->latest()
            ->first();

        if (!$otpRecord) {
            return back()->withErrors([
                'otp' => 'Kode OTP tidak ditemukan.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Cek Expired
        |--------------------------------------------------------------------------
        */

        if (now()->greaterThan($otpRecord->expires_at)) {
            $otpRecord->delete();

            return back()->withErrors([
                'otp' => 'Kode OTP sudah kadaluarsa. Silakan kirim ulang OTP.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Batasi Percobaan OTP
        |--------------------------------------------------------------------------
        */

        if ($otpRecord->attempts >= 5) {
            return back()->withErrors([
                'otp' => 'Terlalu banyak percobaan. Silakan kirim ulang OTP.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Cek OTP
        |--------------------------------------------------------------------------
        */

        if (!Hash::check($request->otp, $otpRecord->code)) {
            $otpRecord->increment('attempts');

            return back()->withErrors([
                'otp' => 'Kode OTP yang Anda masukkan salah.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil User
        |--------------------------------------------------------------------------
        */

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()
                ->route('register')
                ->with(
                    'error',
                    'Data pengguna tidak ditemukan.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Tandai Email Sudah Diverifikasi
        |--------------------------------------------------------------------------
        */

        $user->update([
            'email_verified_at' => now(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Hapus OTP
        |--------------------------------------------------------------------------
        */

        $otpRecord->delete();

        /*
        |--------------------------------------------------------------------------
        | Bersihkan Session OTP
        |--------------------------------------------------------------------------
        */

        session()->forget([
            'otp_email',
            'otp_type',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Redirect Login
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Email berhasil diverifikasi. Silakan login.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | KIRIM ULANG OTP REGISTER
    |--------------------------------------------------------------------------
    */

    public function resendOtp()
    {
        $email = session('otp_email');

        if (!$email) {
            return redirect()
                ->route('register')
                ->with(
                    'error',
                    'Sesi verifikasi telah berakhir.'
                );
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()
                ->route('register')
                ->with(
                    'error',
                    'Data pengguna tidak ditemukan.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Hapus OTP Lama
        |--------------------------------------------------------------------------
        */

        OtpVerification::where('email', $email)
            ->where('type', 'register')
            ->delete();

        /*
        |--------------------------------------------------------------------------
        | Generate OTP Baru
        |--------------------------------------------------------------------------
        */

        $otp = (string) random_int(100000, 999999);

        /*
        |--------------------------------------------------------------------------
        | Simpan OTP Baru
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
        | Kirim OTP Baru
        |--------------------------------------------------------------------------
        */

        Mail::to($email)->send(
            new OtpMail($otp, 'register')
        );

        return back()->with(
            'success',
            'Kode OTP baru telah dikirim ke email Anda.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORGOT PASSWORD
    |--------------------------------------------------------------------------
    */

    /**
     * Menampilkan halaman "Lupa Kata Sandi"
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }


    /**
     * Mengirim OTP Reset Password
     */
    public function sendResetOtp(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validasi Email
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
        ]);

        $email = $request->email;

        /*
        |--------------------------------------------------------------------------
        | Cari User
        |--------------------------------------------------------------------------
        */

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()
                ->withErrors([
                    'email' => 'Email tidak ditemukan di sistem.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Hapus OTP Reset Password Lama
        |--------------------------------------------------------------------------
        */

        OtpVerification::where('email', $email)
            ->where('type', 'reset')
            ->delete();

        /*
        |--------------------------------------------------------------------------
        | Generate OTP 6 Digit
        |--------------------------------------------------------------------------
        */

        $otp = (string) random_int(100000, 999999);

        /*
        |--------------------------------------------------------------------------
        | Simpan OTP ke Database
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
        | Kirim OTP Reset Password
        |--------------------------------------------------------------------------
        */

        Mail::to($email)->send(
            new OtpMail($otp, 'reset')
        );

        /*
        |--------------------------------------------------------------------------
        | Simpan Email Reset ke Session
        |--------------------------------------------------------------------------
        */

        session([
            'reset_password_email' => $email,
            'reset_password_verified' => false,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Redirect ke Halaman OTP
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('password.verify')
            ->with(
                'success',
                'Kode OTP reset password telah dikirim ke email Anda.'
            );
    }


    /**
     * Menampilkan halaman OTP Reset Password
     */
    public function showResetOtp()
    {
        if (!session()->has('reset_password_email')) {
            return redirect()
                ->route('password.request')
                ->with(
                    'error',
                    'Silakan masukkan email terlebih dahulu.'
                );
        }

        return view('auth.reset-otp', [
            'email' => session('reset_password_email'),
        ]);
    }


    /**
     * Verifikasi OTP Reset Password
     */
    public function verifyResetOtp(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validasi OTP
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
        | Ambil Email dari Session
        |--------------------------------------------------------------------------
        */

        $email = session('reset_password_email');

        if (!$email) {
            return redirect()
                ->route('password.request')
                ->with(
                    'error',
                    'Sesi reset password telah berakhir. Silakan ulangi.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil OTP Terbaru
        |--------------------------------------------------------------------------
        */

        $otpRecord = OtpVerification::where('email', $email)
            ->where('type', 'reset')
            ->latest()
            ->first();

        if (!$otpRecord) {
            return back()->withErrors([
                'otp' => 'Kode OTP tidak ditemukan.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Cek Expired
        |--------------------------------------------------------------------------
        */

        if (now()->greaterThan($otpRecord->expires_at)) {
            $otpRecord->delete();

            return back()->withErrors([
                'otp' => 'Kode OTP sudah kadaluarsa. Silakan kirim ulang OTP.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Batasi Percobaan
        |--------------------------------------------------------------------------
        */

        if ($otpRecord->attempts >= 5) {
            return back()->withErrors([
                'otp' => 'Terlalu banyak percobaan. Silakan kirim ulang OTP.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Cek OTP
        |--------------------------------------------------------------------------
        */

        if (!Hash::check($request->otp, $otpRecord->code)) {
            $otpRecord->increment('attempts');

            return back()->withErrors([
                'otp' => 'Kode OTP yang Anda masukkan salah.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | OTP BENAR
        |--------------------------------------------------------------------------
        */

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()
                ->route('password.request')
                ->with(
                    'error',
                    'Data pengguna tidak ditemukan.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | PENTING:
        | OTP reset berhasil membuktikan bahwa user memiliki
        | akses ke email tersebut.
        |
        | Karena login mewajibkan email_verified_at terisi,
        | kita tandai email sebagai sudah diverifikasi.
        |--------------------------------------------------------------------------
        */

        if (is_null($user->email_verified_at)) {
            $user->update([
                'email_verified_at' => now(),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Tandai Reset Password Sudah Terverifikasi
        |--------------------------------------------------------------------------
        */

        session([
            'reset_password_verified' => true,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Hapus OTP
        |--------------------------------------------------------------------------
        |
        | OTP hanya boleh digunakan satu kali.
        |
        */

        $otpRecord->delete();

        /*
        |--------------------------------------------------------------------------
        | Redirect ke Form Password Baru
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('password.reset');
    }


    /**
     * Menampilkan Form Password Baru
     */
    public function showResetPassword()
    {
        if (
            !session()->has('reset_password_email') ||
            !session('reset_password_verified')
        ) {
            return redirect()
                ->route('password.request')
                ->with(
                    'error',
                    'Silakan verifikasi OTP terlebih dahulu.'
                );
        }

        return view('auth.reset-password');
    }


    /**
     * Menyimpan Password Baru
     */
    public function resetPassword(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validasi Password
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Cek Session Reset
        |--------------------------------------------------------------------------
        */

        $email = session('reset_password_email');

        if (
            !$email ||
            !session('reset_password_verified')
        ) {
            return redirect()
                ->route('password.request')
                ->with(
                    'error',
                    'Sesi reset password tidak valid. Silakan ulangi.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Cari User
        |--------------------------------------------------------------------------
        */

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()
                ->route('password.request')
                ->with(
                    'error',
                    'Data pengguna tidak ditemukan.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Update Password
        |--------------------------------------------------------------------------
        */

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Bersihkan Session Reset Password
        |--------------------------------------------------------------------------
        */

        session()->forget([
            'reset_password_email',
            'reset_password_verified',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Kembali ke Login
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Kata sandi berhasil diubah. Silakan login dengan kata sandi baru.'
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

        return redirect()->route('login');
    }
}