<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Toko;
use App\Helpers\GoogleMapsHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TokoController extends Controller
{
    /**
     * 🏪 Tampilkan semua toko milik penjual yang sedang login
     */
    public function index(Request $request)
    {
        $penjual = Auth::guard('penjual')->user();
        $tokos = Toko::where('penjual_id', $penjual->id)->latest()->get();

        if ($request->wantsJson()) {
            return response()->json($tokos);
        }

        return view('penjual.toko.index', compact('tokos'));
    }

    /**
     * ➕ Form buat toko baru
     */
    public function create()
    {
        return view('penjual.toko.create');
    }

    /**
     * 💾 Simpan toko baru
     */
    public function store(Request $request)
    {
        $penjual = Auth::guard('penjual')->user();

        $validated = $request->validate([
            'nama_toko'        => 'required|string|max:255',
            'alamat_toko'      => 'nullable|string',
            'deskripsi'        => 'nullable|string',
            'foto_profil'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'instagram'        => 'nullable|url',
            'facebook'         => 'nullable|url',
            'whatsapp'         => 'required|string',
            'google_map_link'  => 'nullable|url',
        ]);

        $validated['uuid'] = Str::uuid();
        $validated['penjual_id'] = $penjual->id;

        // Upload foto profil jika ada
        if ($request->hasFile('foto_profil')) {
            $path = $request->file('foto_profil')->store('uploads/toko', 'public');
            $validated['foto_profil'] = 'storage/' . $path;
        }

        // 🗺️ Auto-convert Google Maps link dan extract koordinat
        if (!empty($validated['google_map_link'])) {
            // Extract koordinat otomatis dari link
            $coordinates = GoogleMapsHelper::extractCoordinates($validated['google_map_link']);
            if ($coordinates) {
                $validated['latitude'] = (string) $coordinates['lat'];
                $validated['longitude'] = (string) $coordinates['lng'];
            }

            // Convert ke format embed dan simpan di kolom TERPISAH
            // JANGAN timpa google_map_link (biarkan tetap link original dari user)
            $validated['embed_map_link'] = GoogleMapsHelper::convertToEmbed($validated['google_map_link']);
        }

        Toko::create($validated);

        return redirect()->route('penjual.toko.index')
            ->with('success', 'Toko berhasil ditambahkan!');
    }

    /**
     * ✏️ Form edit toko berdasarkan UUID
     */
    public function edit($uuid)
    {
        $penjual = Auth::guard('penjual')->user();
        $toko = Toko::where('uuid', $uuid)
            ->where('penjual_id', $penjual->id)
            ->firstOrFail();

        return view('penjual.toko.edit', compact('toko'));
    }

    /**
     * 🔄 Update data toko
     */
    public function update(Request $request, $uuid)
    {
        $penjual = Auth::guard('penjual')->user();
        $toko = Toko::where('uuid', $uuid)
            ->where('penjual_id', $penjual->id)
            ->firstOrFail();

        $validated = $request->validate([
            'nama_toko'        => 'required|string|max:255',
            'alamat_toko'      => 'nullable|string',
            'deskripsi'        => 'nullable|string',
            'foto_profil'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'instagram'        => 'nullable|url',
            'facebook'         => 'nullable|url',
            'whatsapp'         => 'required|string',
            'google_map_link'  => 'nullable|url',
        ]);

        // 🔁 Ganti foto profil bila diupload ulang
        if ($request->hasFile('foto_profil')) {
            if ($toko->foto_profil && Storage::exists(str_replace('storage/', 'public/', $toko->foto_profil))) {
                Storage::delete(str_replace('storage/', 'public/', $toko->foto_profil));
            }

            $path = $request->file('foto_profil')->store('uploads/toko', 'public');
            $validated['foto_profil'] = 'storage/' . $path;
        }

        // 🗺️ Auto-convert Google Maps link dan extract koordinat
        if (!empty($validated['google_map_link'])) {
            // Extract koordinat otomatis dari link
            $coordinates = GoogleMapsHelper::extractCoordinates($validated['google_map_link']);
            if ($coordinates) {
                $validated['latitude'] = (string) $coordinates['lat'];
                $validated['longitude'] = (string) $coordinates['lng'];
            }

            // Convert ke format embed untuk disimpan (optional)
            $validated['embed_map_link'] = GoogleMapsHelper::convertToEmbed($validated['google_map_link']);
        }

        // 🔄 Update data
        $toko->update($validated);

        return redirect()->route('penjual.toko.index')
            ->with('success', 'Toko berhasil diperbarui!');
    }

    /**
     * ❌ Hapus toko berdasarkan UUID
     */
    public function destroy($uuid)
    {
        $penjual = Auth::guard('penjual')->user();
        $toko = Toko::where('uuid', $uuid)
            ->where('penjual_id', $penjual->id)
            ->firstOrFail();

        if ($toko->foto_profil && Storage::exists(str_replace('storage/', 'public/', $toko->foto_profil))) {
            Storage::delete(str_replace('storage/', 'public/', $toko->foto_profil));
        }

        $toko->delete();

        return redirect()->route('penjual.toko.index')
            ->with('success', 'Toko berhasil dihapus!');
    }

    /**
     * 🔍 Preview Google Maps (AJAX) - Optional untuk preview real-time
     */
    public function previewMap(Request $request)
    {
        $url = $request->input('url');
        
        if (empty($url)) {
            return response()->json(['error' => 'URL tidak boleh kosong'], 400);
        }

        $embedUrl = GoogleMapsHelper::convertToEmbed($url);
        $coordinates = GoogleMapsHelper::extractCoordinates($url);

        return response()->json([
            'embed_url' => $embedUrl,
            'coordinates' => $coordinates,
            'is_valid' => GoogleMapsHelper::isValidGoogleMapsUrl($url)
        ]);
    }
}