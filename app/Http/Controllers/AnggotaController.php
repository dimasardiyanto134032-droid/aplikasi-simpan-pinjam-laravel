<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggotas = Anggota::latest()->get();
        return view('anggota.index', compact('anggotas'));
    }

    public function create()
    {
        return view('anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_anggota' => 'required|unique:anggotas',
            'nama' => 'required',
            'nik' => 'required|digits:16|unique:anggotas',
            'no_hp' => 'required',
            'alamat' => 'required',
        ]);

        Anggota::create($request->all());
        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil ditambahkan.');
    }

    public function edit(Anggota $anggotum)
    {
        return view('anggota.edit', ['anggota' => $anggotum]);
    }

    public function update(Request $request, Anggota $anggotum)
    {
        $request->validate([
            'kode_anggota' => 'required|unique:anggotas,kode_anggota,' . $anggotum->id,
            'nama' => 'required',
            'nik' => 'required|digits:16|unique:anggotas,nik,' . $anggotum->id,
            'no_hp' => 'required',
            'alamat' => 'required',
        ]);

        $anggotum->update($request->all());
        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Anggota $anggotum)
    {
        $anggotum->delete();
        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil dihapus.');
    }
}
