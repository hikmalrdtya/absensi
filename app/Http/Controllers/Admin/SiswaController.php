<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswa = Siswa::with('kelas')->paginate(10);
        return view('admin.siswa.index', compact('siswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('admin.siswa.tambah', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'kelas_id' => 'required|exists:kelas,id',
            'no_hp_orang_tua' => 'required|string|max:20',
        ]);

        Siswa::create([
            'nama' => $request->nama,
            'kelas_id' => $request->kelas_id,
            'no_hp_orang_tua' => $request->no_hp_orang_tua,
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::all();
        return view('admin.siswa.edit', compact('siswa', 'kelas'));
    }

    // ✅ UPDATE PAKAI MODEL
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'kelas_id' => 'required|exists:kelas,id',
            'no_hp_orang_tua' => 'required|string|max:20',
        ]);

        $siswa->update([
            'nama' => $request->nama,
            'kelas_id' => $request->kelas_id,
            'no_hp_orang_tua' => $request->no_hp_orang_tua,
        ]);

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui');
    }

    // ✅ DELETE PAKAI MODEL
    public function destroy(Siswa $siswa)
    {
        $siswa->delete();

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil dihapus');
    }
}
