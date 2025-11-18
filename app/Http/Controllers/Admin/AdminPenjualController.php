<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penjual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdminPenjualController extends Controller
{
    /**
     * Tampilkan semua penjual dengan statistik
     */
    public function index()
    {
        $penjuals = Penjual::latest()->get()->map(function($penjual) {
            // Hitung jumlah toko
            $jumlahToko = DB::table('tokos')
                ->where('penjual_id', $penjual->id)
                ->count();
            
            // Ambil ID semua toko milik penjual
            $tokoIds = DB::table('tokos')
                ->where('penjual_id', $penjual->id)
                ->pluck('id');
            
            // Hitung total produk dari semua toko
            $totalProduk = DB::table('produks')
                ->whereIn('toko_id', $tokoIds)
                ->count();
            
            // Hitung total pesanan
            $totalPesanan = DB::table('pesanans')
                ->join('produks', 'pesanans.produk_id', '=', 'produks.id')
                ->whereIn('produks.toko_id', $tokoIds)
                ->count();
            
            // Tambahkan data statistik ke object penjual
            $penjual->jumlah_toko = $jumlahToko;
            $penjual->total_produk = $totalProduk;
            $penjual->total_pesanan = $totalPesanan;
            
            return $penjual;
        });
        
        return view('admin.penjual.index', compact('penjuals'));
    }

    /**
     * Toggle status penjual (Aktif/Nonaktif)
     */
    public function toggleStatus(Request $request, $id)
    {
        $penjual = Penjual::findOrFail($id);
        $admin = Auth::guard('admin')->user();
        
        if ($penjual->isActive()) {
            // Nonaktifkan penjual
            $reason = $request->input('reason', 'Dinonaktifkan oleh admin');
            $penjual->deactivate($reason, $admin->id);
            
            $message = "Penjual {$penjual->username} berhasil dinonaktifkan.";
            $type = 'warning';
        } else {
            // Aktifkan penjual
            $penjual->activate();
            
            $message = "Penjual {$penjual->username} berhasil diaktifkan kembali.";
            $type = 'success';
        }
        
        return back()->with($type, $message);
    }

    /**
     * Form deaktivasi dengan alasan
     */
    public function showDeactivateForm($id)
    {
        $penjual = Penjual::findOrFail($id);
        
        if ($penjual->isInactive()) {
            return back()->with('info', 'Penjual sudah dalam status nonaktif.');
        }
        
        return view('admin.penjual.deactivate', compact('penjual'));
    }

    /**
     * Proses deaktivasi dengan alasan
     */
    public function deactivate(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ], [
            'reason.required' => 'Alasan deaktivasi wajib diisi',
            'reason.max' => 'Alasan maksimal 500 karakter'
        ]);
        
        $penjual = Penjual::findOrFail($id);
        $admin = Auth::guard('admin')->user();
        
        $penjual->deactivate($request->reason, $admin->id);
        
        return redirect()->route('admin.penjual.index')
            ->with('success', "Penjual {$penjual->username} berhasil dinonaktifkan.");
    }

    /**
     * Aktifkan penjual
     */
    public function activate($id)
    {
        $penjual = Penjual::findOrFail($id);
        
        if ($penjual->isActive()) {
            return back()->with('info', 'Penjual sudah dalam status aktif.');
        }
        
        $penjual->activate();
        
        return back()->with('success', "Penjual {$penjual->username} berhasil diaktifkan kembali.");
    }

    /**
     * Halaman monitoring detail penjual
     */
    public function monitoring($id)
    {
        $penjual = Penjual::findOrFail($id);
        
        // Ambil semua toko milik penjual
        $tokos = DB::table('tokos')
            ->where('penjual_id', $id)
            ->get()
            ->map(function($toko) {
                // Hitung jumlah produk per toko
                $toko->jumlah_produk = DB::table('produks')
                    ->where('toko_id', $toko->id)
                    ->count();
                
                // Hitung total pesanan per toko
                $toko->total_pesanan = DB::table('pesanans')
                    ->join('produks', 'pesanans.produk_id', '=', 'produks.id')
                    ->where('produks.toko_id', $toko->id)
                    ->count();
                
                return $toko;
            });
        
        // ID semua toko
        $tokoIds = $tokos->pluck('id')->toArray();
        
        // Statistik Overview
        $totalToko = $tokos->count();
        $totalProduk = DB::table('produks')
            ->whereIn('toko_id', $tokoIds)
            ->count();
        $totalPesanan = DB::table('pesanans')
            ->join('produks', 'pesanans.produk_id', '=', 'produks.id')
            ->whereIn('produks.toko_id', $tokoIds)
            ->count();
        
        // Total Pendapatan
        $totalPendapatan = DB::table('pesanans')
            ->join('produks', 'pesanans.produk_id', '=', 'produks.id')
            ->whereIn('produks.toko_id', $tokoIds)
            ->where('pesanans.status', 'selesai')
            ->sum('pesanans.total_harga');
        
        // Daftar Produk
        $produks = DB::table('produks')
            ->join('tokos', 'produks.toko_id', '=', 'tokos.id')
            ->join('kategoris', 'produks.kategori_id', '=', 'kategoris.id')
            ->whereIn('produks.toko_id', $tokoIds)
            ->select(
                'produks.*',
                'tokos.nama_toko',
                'kategoris.nama_kategori'
            )
            ->latest('produks.created_at')
            ->get();
        
        // Grafik Penjualan Bulanan (12 bulan terakhir)
        $chartLabels = [];
        $chartData = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $chartLabels[] = $date->isoFormat('MMM YYYY');
            
            $count = DB::table('pesanans')
                ->join('produks', 'pesanans.produk_id', '=', 'produks.id')
                ->whereIn('produks.toko_id', $tokoIds)
                ->whereYear('pesanans.tanggal_pemesanan', $date->year)
                ->whereMonth('pesanans.tanggal_pemesanan', $date->month)
                ->count();
            
            $chartData[] = $count;
        }
        
        // Produk Terlaris (Top 5)
        $produkTerlaris = DB::table('pesanans')
            ->join('produks', 'pesanans.produk_id', '=', 'produks.id')
            ->whereIn('produks.toko_id', $tokoIds)
            ->select(
                'produks.nama',
                DB::raw('SUM(pesanans.jumlah) as total_terjual'),
                DB::raw('COUNT(pesanans.id) as jumlah_pesanan')
            )
            ->groupBy('produks.id', 'produks.nama')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();
        
        // Riwayat Pesanan Terbaru (10 terakhir)
        $pesananTerbaru = DB::table('pesanans')
            ->join('produks', 'pesanans.produk_id', '=', 'produks.id')
            ->join('tokos', 'produks.toko_id', '=', 'tokos.id')
            ->whereIn('produks.toko_id', $tokoIds)
            ->select(
                'pesanans.*',
                'produks.nama as nama_produk',
                'produks.harga',
                'tokos.nama_toko'
            )
            ->orderByDesc('pesanans.tanggal_pemesanan')
            ->limit(10)
            ->get();
        
        return view('admin.penjual.monitoring', compact(
            'penjual',
            'tokos',
            'totalToko',
            'totalProduk',
            'totalPesanan',
            'totalPendapatan',
            'produks',
            'chartLabels',
            'chartData',
            'produkTerlaris',
            'pesananTerbaru'
        ));
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
            'status' => 'active', // Default aktif
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