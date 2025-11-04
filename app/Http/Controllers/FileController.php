<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function index()
    {
        return response()->json(File::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'filepath' => 'required|string',
            'fileable_id' => 'required|string',
            'fileable_type' => 'required|string',
        ]);

        $file = File::create($validated);
        return response()->json($file, 201);
    }

    public function show($id)
    {
        return response()->json(File::findOrFail($id));
    }

    public function destroy($id)
    {
        File::destroy($id);
        return response()->json(['message' => 'File deleted successfully']);
    }
}
