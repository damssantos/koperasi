<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'no_hp' => 'required|numeric|digits_between:10,15',
            'alamat' => 'required|string|min:10',
        ], [
            'no_hp.required' => 'Nomor handphone wajib diisi.',
            'no_hp.numeric' => 'Nomor handphone harus berupa angka.',
            'no_hp.digits_between' => 'Nomor handphone harus terdiri dari 10 sampai 15 digit.',
            'alamat.required' => 'Alamat tinggal wajib diisi.',
            'alamat.min' => 'Mohon masukkan alamat tinggal Anda dengan lebih lengkap (minimal 10 karakter).',
        ]);

        $user->update([
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui.');
    }

    public function updateAvatar(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'avatar.required' => 'File foto profil wajib diunggah.',
            'avatar.image' => 'File harus berupa gambar.',
            'avatar.mimes' => 'Format gambar yang diperbolehkan adalah jpeg, png, jpg, webp.',
            'avatar.max' => 'Ukuran gambar maksimal adalah 2MB.',
        ]);

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        
        $user->update([
            'avatar' => $path,
        ]);

        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui.');
    }
}
