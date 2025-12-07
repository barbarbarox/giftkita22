<?php

namespace App\Imports;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Toko;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProdukImport
{
    protected $successCount = 0;
    protected $errorCount = 0;
    protected $errors = [];
    protected $validationErrors = [];

    /**
     * Import data dari file Excel
     */
    public function import($file)
    {
        $penjual = Auth::guard('penjual')->user();
        $tokoIds = $penjual->tokos->pluck('id')->toArray();

        // Import menggunakan fast-excel
        $collection = fastexcel()->import($file);

        foreach ($collection as $index => $row) {
            $rowNumber = $index + 2; // +2 karena header di row 1, index mulai dari 0

            // Validasi data
            $validator = Validator::make($row, [
                'nama_produk' => 'required|string|max:255',
                'harga' => 'required|numeric|min:0',
                'kategori' => 'required|string',
                'nama_toko' => 'required|string',
            ], [
                'nama_produk.required' => 'Nama produk wajib diisi',
                'harga.required' => 'Harga wajib diisi',
                'harga.numeric' => 'Harga harus berupa angka',
                'kategori.required' => 'Kategori wajib diisi',
                'nama_toko.required' => 'Nama toko wajib diisi',
            ]);

            if ($validator->fails()) {
                $this->errorCount++;
                $this->validationErrors[] = [
                    'row' => $rowNumber,
                    'errors' => $validator->errors()->all()
                ];
                continue;
            }

            try {
                // Cari kategori berdasarkan nama (case-insensitive & trim whitespace)
                $kategori = Kategori::whereRaw('LOWER(TRIM(nama_kategori)) = ?', [
                    strtolower(trim($row['kategori']))
                ])->first();
                
                if (!$kategori) {
                    throw new \Exception("Kategori '{$row['kategori']}' tidak ditemukan");
                }

                // Cari toko berdasarkan nama (case-insensitive & trim whitespace)
                $toko = Toko::whereRaw('LOWER(TRIM(nama_toko)) = ?', [
                    strtolower(trim($row['nama_toko']))
                ])->whereIn('id', $tokoIds)->first();

                if (!$toko) {
                    throw new \Exception("Toko '{$row['nama_toko']}' tidak ditemukan atau bukan milik Anda");
                }

                // Buat produk
                Produk::create([
                    'nama' => trim($row['nama_produk']),
                    'deskripsi' => isset($row['deskripsi']) ? trim($row['deskripsi']) : null,
                    'harga' => $row['harga'],
                    'kategori_id' => $kategori->id,
                    'toko_id' => $toko->id,
                ]);

                $this->successCount++;
            } catch (\Exception $e) {
                $this->errorCount++;
                $this->errors[] = [
                    'row' => $rowNumber,
                    'data' => $row,
                    'error' => $e->getMessage()
                ];
            }
        }

        return $this->getStats();
    }

    /**
     * Get import statistics
     */
    public function getStats()
    {
        return [
            'success' => $this->successCount,
            'error' => $this->errorCount,
            'errors' => $this->errors,
            'validation_errors' => $this->validationErrors
        ];
    }
}