<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKoperasi;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = AnggotaKoperasi::orderBy('tanggal_join', 'desc')->orderBy('id', 'desc')->get();
        $totalAnggota = $anggota->count();
        $totalPokok = $anggota->sum('simpanan_pokok');
        $totalSaldo = $anggota->sum('total_saldo');

        return view('anggota', compact('anggota', 'totalAnggota', 'totalPokok', 'totalSaldo'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_anggota' => 'required|string|unique:anggota_koperasi,id_anggota',
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'tanggal_join' => 'required|date',
        ], [
            'id_anggota.required' => 'ID Anggota wajib diisi.',
            'id_anggota.unique' => 'ID Anggota ini sudah terdaftar.',
            'nama.required' => 'Nama lengkap wajib diisi.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'tanggal_join.required' => 'Tanggal bergabung wajib diisi.',
        ]);

        $pokok = (int)$request->input('simpanan_pokok', 100000);

        AnggotaKoperasi::create([
            'id_anggota' => $data['id_anggota'],
            'nama' => $data['nama'],
            'no_hp' => $data['no_hp'],
            'tanggal_join' => $data['tanggal_join'],
            'simpanan_pokok' => $pokok,
            'simpanan_wajib' => 0,
            'simpanan_sukarela' => 0,
            'total_saldo' => $pokok,
        ]);

        return redirect()->route('anggota.index')->with('success', 'Anggota baru berhasil ditambahkan.');
    }

    public function show(AnggotaKoperasi $anggota)
    {
        return view('anggota-detail', compact('anggota'));
    }

    public function update(Request $request, AnggotaKoperasi $anggota)
    {
        $data = $request->validate([
            'id_anggota' => 'required|string|unique:anggota_koperasi,id_anggota,' . $anggota->id,
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'tanggal_join' => 'required|date',
            'simpanan_pokok' => 'required|numeric|min:0',
            'simpanan_wajib' => 'required|numeric|min:0',
            'simpanan_sukarela' => 'required|numeric|min:0',
        ], [
            'id_anggota.required' => 'ID Anggota wajib diisi.',
            'id_anggota.unique' => 'ID Anggota ini sudah terdaftar.',
            'nama.required' => 'Nama lengkap wajib diisi.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'tanggal_join.required' => 'Tanggal bergabung wajib diisi.',
            'simpanan_pokok.required' => 'Simpanan pokok wajib diisi.',
            'simpanan_wajib.required' => 'Simpanan wajib wajib diisi.',
            'simpanan_sukarela.required' => 'Simpanan sukarela wajib diisi.',
        ]);

        $data['total_saldo'] = (int)$data['simpanan_pokok'] + (int)$data['simpanan_wajib'] + (int)$data['simpanan_sukarela'];

        $anggota->update($data);

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function print()
    {
        $anggota = AnggotaKoperasi::orderBy('tanggal_join', 'desc')->orderBy('id', 'desc')->get();
        return view('exports.anggota-print', compact('anggota'));
    }

    public function destroy(AnggotaKoperasi $anggota)
    {
        $anggota->delete();
        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
