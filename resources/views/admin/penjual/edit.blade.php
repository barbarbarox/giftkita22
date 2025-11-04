@extends('admin.layouts.app')

@section('content')
<div class="p-6 max-w-lg">
    <h1 class="text-2xl font-semibold mb-4">Edit Data Penjual</h1>

    <form action="{{ route('admin.penjual.update', $penjual->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label class="block mb-2 text-gray-700">Username</label>
        <input type="text" name="username" value="{{ old('username', $penjual->username) }}" class="w-full border rounded p-2 mb-4" required>

        <label class="block mb-2 text-gray-700">Email</label>
        <input type="email" name="email" value="{{ old('email', $penjual->email) }}" class="w-full border rounded p-2 mb-4" required>

        <label class="block mb-2 text-gray-700">No HP</label>
        <input type="text" name="no_hp" value="{{ old('no_hp', $penjual->no_hp) }}" class="w-full border rounded p-2 mb-4">

        <label class="block mb-2 text-gray-700">Password (kosongkan jika tidak diubah)</label>
        <input type="password" name="password" class="w-full border rounded p-2 mb-4">

        <label class="block mb-2 text-gray-700">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="w-full border rounded p-2 mb-4">

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif      

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
    </form>

</div>
@endsection
