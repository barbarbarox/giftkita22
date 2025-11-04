<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penjual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminPenjualController extends Controller
{
    /**
     * Tampilkan semua penjual
     */
    public function index()
    {
        $penjuals = Penjual::latest()->get();
        return view('admin.penjual.index', compact('penjuals'));
    }

    /**
     * Form tambah penjual
     */
    public function create()
    {
        return view('admin.penjual.create');
    }

    /**
     * Simpan penjual baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:penjuals,username',
            'email' => 'required|email|unique:penjuals,email',
            'password' => 'required|min:6|confirmed',
            'no_hp' => 'nullable|string|max:15',
        ]);

        Penjual::create([
            'id' => (string) Str::uuid(),
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'no_hp' => $validated['no_hp'] ?? null,
        ]);

        return redirect()->route('admin.penjual.index')->with('success', 'Penjual berhasil ditambahkan.');
    }

    /**
     * Form edit penjual
     */
    public function edit($id)
    {
        $penjual = Penjual::findOrFail($id);
        return view('admin.penjual.edit', compact('penjual'));
    }

    /**
     * Update penjual
     */
    public function update(Request $request, $id)
    {
        $penjual = Penjual::findOrFail($id);

        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:penjuals,username,' . $id,
            'email' => 'required|email|unique:penjuals,email,' . $id,
            'no_hp' => 'nullable|string|max:15',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $penjual->username = $validated['username'];
        $penjual->email = $validated['email'];
        $penjual->no_hp = $validated['no_hp'] ?? null;

        if (!empty($validated['password'])) {
            $penjual->password = Hash::make($validated['password']);
        }

        $penjual->save();

        return redirect()->route('admin.penjual.index')
            ->with('success', 'Data penjual berhasil diperbarui.');
    }


    /**
     * Hapus penjual
     */
    public function destroy($id)
    {
        $penjual = Penjual::findOrFail($id);
        $penjual->delete();

        return redirect()->route('admin.penjual.index')->with('success', 'Penjual berhasil dihapus.');
    }
}
