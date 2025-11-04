<?php

namespace App\Http\Controllers;

use App\Models\Penjual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenjualController extends Controller
{
    public function index()
    {
        return response()->json(Penjual::with('toko')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|unique:penjuals',
            'email' => 'required|email|unique:penjuals',
            'password' => 'required|min:6',
            'no_hp' => 'required',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $penjual = Penjual::create($validated);

        return response()->json($penjual, 201);
    }

    public function show($id)
    {
        return response()->json(Penjual::with('toko')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $penjual = Penjual::findOrFail($id);
        $penjual->update($request->only(['username', 'email', 'no_hp']));
        return response()->json($penjual);
    }

    public function destroy($id)
    {
        Penjual::destroy($id);
        return response()->json(['message' => 'Penjual deleted successfully']);
    }
}
