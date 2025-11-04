@extends('layouts.penjual')

@section('title', 'Pesanan Masuk | GiftKita Seller')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <div class="flex items-center gap-3 mb-6">
        <span class="text-3xl">📦</span>
        <h1 class="text-3xl font-bold text-[#007daf]">Pesanan Masuk</h1>
    </div>

    {{-- TAB NAVIGASI --}}
    <div class="flex flex-wrap gap-3 mb-6">
        <button class="tab-btn bg-[#007daf] text-white px-5 py-2 rounded-lg font-semibold active" data-status="pending">
            Pending
        </button>
        <button class="tab-btn bg-[#c771d4] text-white px-5 py-2 rounded-lg font-semibold" data-status="diproses">
            Diproses
        </button>
        <button class="tab-btn bg-[#ffb829] text-white px-5 py-2 rounded-lg font-semibold" data-status="selesai">
            Selesai
        </button>
    </div>

    {{-- ISI TAB --}}
    @foreach (['pending', 'diproses', 'selesai'] as $status)
        <div class="tab-content {{ $status === 'pending' ? '' : 'hidden' }}" id="tab-{{ $status }}">
            <div class="overflow-x-auto rounded-xl shadow-lg border border-gray-200 bg-white">
                <table class="min-w-full text-sm text-left border-collapse">
                    <thead class="bg-gradient-to-r from-[#007daf] via-[#c771d4] to-[#ffb829] text-white">
                        <tr>
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">Produk</th>
                            <th class="px-4 py-3">Nama Pembeli</th>
                            <th class="px-4 py-3">Jumlah</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $filtered = $pesanans->where('status', $status);
                            $no = 1; // Penomoran manual agar urut setelah filter
                        @endphp

                        @forelse ($filtered as $pesanan)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-4 py-3">{{ $no++ }}</td>
                                <td class="px-4 py-3">
                                    <span class="font-semibold text-[#007daf]">{{ $pesanan->produk->nama ?? '-' }}</span>
                                    <p class="text-xs text-gray-500">Toko: {{ $pesanan->produk->toko->nama_toko ?? '-' }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-semibold">{{ $pesanan->nama_pembeli }}</div>
                                    <div class="text-xs text-gray-500">{{ $pesanan->no_hp_pembeli }}</div>
                                    <div class="text-xs text-gray-400">{{ $pesanan->email_pembeli }}</div>
                                </td>
                                <td class="px-4 py-3">{{ $pesanan->jumlah }}</td>
                                <td class="px-4 py-3">
                                    {{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('d M Y H:i') }}
                                </td>
                                <td class="px-4 py-3">
                                    <select data-id="{{ $pesanan->id }}" class="status-select border border-gray-300 rounded-md p-1 text-sm">
                                        <option value="pending" {{ $pesanan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="diproses" {{ $pesanan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="selesai" {{ $pesanan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pesanan->no_hp_pembeli) }}" 
                                       target="_blank" 
                                       class="text-green-600 font-semibold hover:underline">
                                       Hubungi via WhatsApp
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                    Belum ada pesanan {{ $status }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>

{{-- SWEETALERT CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.tab-btn');
    const contents = document.querySelectorAll('.tab-content');

    // Tab handler
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active', 'scale-105', 'ring-2', 'ring-offset-2'));
            tab.classList.add('active', 'scale-105', 'ring-2', 'ring-offset-2', 'ring-[#007daf]');
            contents.forEach(c => c.classList.add('hidden'));
            document.getElementById(`tab-${tab.dataset.status}`).classList.remove('hidden');
        });
    });

    // Update status AJAX
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', async (e) => {
            const id = e.target.dataset.id;
            const status = e.target.value;

            try {
                const response = await fetch(`/penjual/pesanan/${id}/status`, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ status })
                });

                const result = await response.json();

                if (result.success) {
                    Swal.fire({
                        title: '✅ Status Diperbarui!',
                        text: `Pesanan telah diubah menjadi "${status}"`,
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(() => location.reload(), 1600);
                } else {
                    Swal.fire({
                        title: '⚠️ Gagal Memperbarui!',
                        text: result.message || 'Terjadi kesalahan saat memperbarui status.',
                        icon: 'error',
                        confirmButtonColor: '#d33'
                    });
                }
            } catch (error) {
                Swal.fire({
                    title: '❌ Kesalahan Server!',
                    text: 'Tidak dapat memperbarui status pesanan.',
                    icon: 'error',
                    confirmButtonColor: '#d33'
                });
            }
        });
    });
});
</script>
@endsection
