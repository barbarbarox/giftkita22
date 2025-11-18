<?php

namespace App\Http\Controllers;

use App\Models\LaporanPenjual;
use App\Models\Penjual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LaporanPenjualController extends Controller
{
    // Tampilkan form laporan
    public function create()
    {
        // Ambil semua penjual yang aktif dari tabel penjuals
        // Gunakan relasi toko untuk mendapatkan nama_toko
        $penjualList = Penjual::with('toko')
            ->where('status', 'active') // sesuai dengan enum di tabel: 'active', 'inactive'
            ->get()
            ->sortBy(function($penjual) {
                return $penjual->toko->nama_toko ?? $penjual->username;
            });

        return view('laporan.create', compact('penjualList'));
    }

    // Simpan laporan
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'penjual_id' => 'required|exists:penjuals,id', // Update ke penjuals
            'nama_pelapor' => 'required|string|max:255',
            'email_pelapor' => 'required|email|max:255',
            'no_telp_pelapor' => 'nullable|string|max:20',
            'kategori' => 'required|in:penipuan,produk_palsu,pelayanan_buruk,pengiriman_bermasalah,lainnya',
            'deskripsi' => 'required|string|min:20',
            'bukti_file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // max 2MB
        ], [
            'penjual_id.required' => 'Silakan pilih penjual yang ingin dilaporkan.',
            'penjual_id.exists' => 'Penjual tidak ditemukan.',
            'nama_pelapor.required' => 'Nama wajib diisi.',
            'email_pelapor.required' => 'Email wajib diisi.',
            'email_pelapor.email' => 'Format email tidak valid.',
            'kategori.required' => 'Kategori laporan wajib dipilih.',
            'kategori.in' => 'Kategori laporan tidak valid.',
            'deskripsi.required' => 'Deskripsi laporan wajib diisi.',
            'deskripsi.min' => 'Deskripsi minimal 20 karakter.',
            'bukti_file.image' => 'File harus berupa gambar.',
            'bukti_file.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'bukti_file.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only([
            'penjual_id',
            'nama_pelapor',
            'email_pelapor',
            'no_telp_pelapor',
            'kategori',
            'deskripsi',
        ]);

        // Upload bukti file jika ada
        if ($request->hasFile('bukti_file')) {
            $file = $request->file('bukti_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('laporan_bukti', $fileName, 'public');
            $data['bukti_file'] = $filePath;
        }

        // Simpan laporan
        LaporanPenjual::create($data);

        return redirect()->route('faq.index')
            ->with('success', 'Laporan berhasil dikirim! Tim kami akan meninjau laporan Anda segera.');
    }

    // Tampilkan daftar penjual untuk dipilih (AJAX)
    public function getPenjual(Request $request)
    {
        $search = $request->input('search');
        
        $penjual = Penjual::where('status', 'aktif')
            ->when($search, function($q) use ($search) {
                $q->where('nama_toko', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%");
            })
            ->select('id', 'nama_toko', 'nama_lengkap', 'foto_profil')
            ->limit(10)
            ->get();

        return response()->json($penjual);
    }
}