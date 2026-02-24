<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = Kelas::with('waliKelas')->get();
        return view('admin.kela.index', compact('kelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $petugas = User::where('role', 'petugas')->get();
        return view('admin.kela.tambah', compact('petugas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas'     => 'required|string|max:255',
            'jurusan'        => 'required|string|max:255',
            'wali_kelas_id'  => 'nullable|exists:users,id',
        ]);

        Kelas::create([
            'nama_kelas'    => $request->nama_kelas,
            'jurusan'       => $request->jurusan,
            'wali_kelas_id' => $request->wali_kelas_id,
        ]);

        return redirect()
            ->route('admin.kela.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelas $kela)
    {
        $petugas = User::where('role', 'petugas')->get();
        return view('admin.kela.edit', compact('kela', 'petugas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelas $kela)
    {
        $request->validate([
            'nama_kelas'     => 'required|string|max:255',
            'jurusan'        => 'required|string|max:255',
            'wali_kelas_id'  => 'nullable|exists:users,id',
        ]);

        $kela->update([
            'nama_kelas'    => $request->nama_kelas,
            'jurusan'       => $request->jurusan,
            'wali_kelas_id' => $request->wali_kelas_id,
        ]);

        return redirect()
            ->route('admin.kela.index')
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelas $kela)
    {
        $kela->delete();

        return redirect()
            ->route('admin.kela.index')
            ->with('success', 'Kelas berhasil dihapus.');
    }
}
