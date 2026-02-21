<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $petuga = User::where('role', 'petugas')->get();
        return view('admin.petuga.index', compact('petuga'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.petuga.tambah');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:3|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'petugas',
        ]);

        return redirect()->route('admin.petuga.index')->with('success', 'Petugas berhasil ditambahkan.');
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
    public function edit(User $petuga)
    {
        if ($petuga->role !== 'petugas') {
            abort(404);
        }

        return view('admin.petuga.edit', compact('petuga'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $petuga)
    {
        if ($petuga->role !== 'petugas') {
            abort(404);
        }

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $petuga->id,
            'password' => 'nullable|min:3|confirmed',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $petuga->update($data);

        return redirect()
            ->route('admin.petuga.index')->with('success', 'Petugas berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $petuga)
    {
        if ($petuga->role !== 'petugas') {
            abort(404);
        }

        $petuga->delete();

        return redirect()
            ->route('admin.petuga.index')
            ->with('success', 'Petugas berhasil dihapus');
    }
}
