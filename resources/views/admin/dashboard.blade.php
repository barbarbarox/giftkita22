@extends('admin.layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold mb-4">Dashboard Admin</h1>

    <div class="grid grid-cols-3 gap-4">
        <div class="bg-blue-100 p-4 rounded shadow">
            <h2 class="text-xl font-bold">Penjual</h2>
            <p class="text-gray-600">Kelola akun penjual di sini.</p>
        </div>
        <div class="bg-green-100 p-4 rounded shadow">
            <h2 class="text-xl font-bold">Kategori</h2>
            <p class="text-gray-600">Tambahkan dan kelola kategori produk.</p>
        </div>
        <div class="bg-yellow-100 p-4 rounded shadow">
            <h2 class="text-xl font-bold">FAQ</h2>
            <p class="text-gray-600">Buat dan atur pertanyaan umum pembeli.</p>
        </div>
    </div>
</div>
@endsection
