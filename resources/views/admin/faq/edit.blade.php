@extends('admin.layouts.app')

@section('title', 'Edit FAQ')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Edit FAQ</h1>

    <form action="{{ route('admin.faq.update', $faq->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="pertanyaan" class="block font-semibold">Pertanyaan</label>
            <input type="text" name="pertanyaan" id="pertanyaan" value="{{ old('pertanyaan', $faq->pertanyaan) }}" class="w-full border rounded p-2">
        </div>

        <div>
            <label for="jawaban" class="block font-semibold">Jawaban</label>
            <textarea name="jawaban" id="jawaban" rows="5" class="w-full border rounded p-2">{{ old('jawaban', $faq->jawaban) }}</textarea>
        </div>

        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Update</button>
    </form>
</div>
@endsection
