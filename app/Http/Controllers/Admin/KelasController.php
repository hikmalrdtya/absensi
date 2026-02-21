<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = Kelas::all();
        return view('admin.kela.index', compact('kelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kela.tambah');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
        ]);

        return redirect()->route('admin.kela.index')->with('success', 'Kelas berhasil ditambahkan.');
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
    public function edit(Kelas $kela)
    {
        if (!$kela) {
            abort(404);
        }
        return view('admin.kela.edit', compact('kela'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelas $kela)
    {
        if (!$kela) {
            abort(404);
        }

        $request->validate([
            'nama_kelas' => 'required|string|max:255',
        ]);

        $kela->update([
            'nama_kelas' => $request->nama_kelas,
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
        if (!$kela) {
            abort(404);
        }

        $kela->delete();

        return redirect()
            ->route('admin.kela.index')
            ->with('success', 'Kelas berhasil dihapus.');
    }
}
