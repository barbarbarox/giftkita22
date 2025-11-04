<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        return response()->json(Faq::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required',
            'jawaban' => 'required',
        ]);

        $faq = Faq::create($validated);
        return response()->json($faq, 201);
    }

    public function show($id)
    {
        return response()->json(Faq::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);
        $faq->update($request->only(['pertanyaan', 'jawaban']));
        return response()->json($faq);
    }

    public function destroy($id)
    {
        Faq::destroy($id);
        return response()->json(['message' => 'FAQ deleted successfully']);
    }
}
