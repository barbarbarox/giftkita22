<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        echo "\n🚀 Memulai update tabel pesanans...\n";

        // STEP 1: Tambah kolom jika belum ada
        Schema::table('pesanans', function (Blueprint $table) {
            if (!Schema::hasColumn('pesanans', 'toko_id')) {
                echo "  ➕ Menambah kolom toko_id...\n";
                $table->char('toko_id', 36)->nullable()->after('produk_id');
            } else {
                echo "  ✓ Kolom toko_id sudah ada\n";
            }
            
            if (!Schema::hasColumn('pesanans', 'total_harga')) {
                echo "  ➕ Menambah kolom total_harga...\n";
                $table->decimal('total_harga', 12, 2)->after('jumlah')->default(0);
            } else {
                echo "  ✓ Kolom total_harga sudah ada\n";
            }
            
            if (!Schema::hasColumn('pesanans', 'catatan_penjual')) {
                echo "  ➕ Menambah kolom catatan_penjual...\n";
                $table->text('catatan_penjual')->nullable()->after('status');
            } else {
                echo "  ✓ Kolom catatan_penjual sudah ada\n";
            }
        });

        // STEP 2: Cek dan bersihkan data
        echo "\n🔍 Mengecek data pesanan...\n";
        
        // Cek pesanan dengan produk yang tidak ada
        $invalidProduk = DB::table('pesanans')
            ->whereNotIn('produk_id', function($query) {
                $query->select('id')->from('produks');
            })
            ->count();
        
        if ($invalidProduk > 0) {
            echo "  ⚠️  Ditemukan {$invalidProduk} pesanan dengan produk invalid. Menghapus...\n";
            DB::table('pesanans')
                ->whereNotIn('produk_id', function($query) {
                    $query->select('id')->from('produks');
                })
                ->delete();
        }

        // STEP 3: Isi toko_id dari produk
        echo "\n📝 Mengisi toko_id dari produk...\n";
        $updated = DB::statement("
            UPDATE pesanans p
            JOIN produks pr ON p.produk_id = pr.id 
            SET p.toko_id = pr.toko_id
            WHERE p.toko_id IS NULL OR p.toko_id = ''
        ");
        echo "  ✓ toko_id telah diisi\n";

        // STEP 4: Cek pesanan dengan toko_id invalid
        $invalidToko = DB::table('pesanans')
            ->whereNotNull('toko_id')
            ->whereNotIn('toko_id', function($query) {
                $query->select('id')->from('tokos');
            })
            ->count();
        
        if ($invalidToko > 0) {
            echo "  ⚠️  Ditemukan {$invalidToko} pesanan dengan toko_id invalid. Menghapus...\n";
            DB::table('pesanans')
                ->whereNotNull('toko_id')
                ->whereNotIn('toko_id', function($query) {
                    $query->select('id')->from('tokos');
                })
                ->delete();
        }

        // STEP 5: Cek apakah masih ada toko_id NULL
        $nullTokoId = DB::table('pesanans')->whereNull('toko_id')->count();
        
        if ($nullTokoId > 0) {
            echo "  ⚠️  Masih ada {$nullTokoId} pesanan dengan toko_id NULL. Menghapus...\n";
            DB::table('pesanans')->whereNull('toko_id')->delete();
        }

        // STEP 6: Isi total_harga
        echo "\n💰 Menghitung total_harga...\n";
        DB::statement("
            UPDATE pesanans p
            JOIN produks pr ON p.produk_id = pr.id 
            SET p.total_harga = pr.harga * p.jumlah
            WHERE p.total_harga = 0 OR p.total_harga IS NULL
        ");
        echo "  ✓ total_harga telah dihitung\n";

        // STEP 7: Ubah toko_id menjadi NOT NULL
        echo "\n🔧 Mengubah toko_id menjadi NOT NULL...\n";
        Schema::table('pesanans', function (Blueprint $table) {
            $table->char('toko_id', 36)->nullable(false)->change();
        });

        // STEP 8: Tambah foreign key & index
        echo "\n🔗 Menambah foreign key dan index...\n";
        Schema::table('pesanans', function (Blueprint $table) {
            $foreignKeys = $this->getForeignKeys('pesanans');
            
            if (!in_array('pesanans_toko_id_foreign', $foreignKeys)) {
                $table->foreign('toko_id', 'pesanans_toko_id_foreign')
                      ->references('id')->on('tokos')->onDelete('cascade');
                echo "  ✓ Foreign key toko_id ditambahkan\n";
            } else {
                echo "  ✓ Foreign key toko_id sudah ada\n";
            }
            
            $indexes = $this->getIndexes('pesanans');
            
            if (!in_array('pesanans_toko_id_index', $indexes)) {
                $table->index('toko_id');
                echo "  ✓ Index toko_id ditambahkan\n";
            }
            if (!in_array('pesanans_status_index', $indexes)) {
                $table->index('status');
                echo "  ✓ Index status ditambahkan\n";
            }
            if (!in_array('pesanans_tanggal_pemesanan_index', $indexes)) {
                $table->index('tanggal_pemesanan');
                echo "  ✓ Index tanggal_pemesanan ditambahkan\n";
            }
        });

        // STEP 9: Update enum status
        echo "\n📊 Update status enum...\n";
        $this->updateStatusEnum();

        $totalPesanan = DB::table('pesanans')->count();
        echo "\n✅ Migration berhasil!\n";
        echo "📊 Total pesanan sekarang: {$totalPesanan}\n\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $foreignKeys = $this->getForeignKeys('pesanans');
            if (in_array('pesanans_toko_id_foreign', $foreignKeys)) {
                $table->dropForeign('pesanans_toko_id_foreign');
            }
            
            $indexes = $this->getIndexes('pesanans');
            if (in_array('pesanans_toko_id_index', $indexes)) {
                $table->dropIndex('pesanans_toko_id_index');
            }
            if (in_array('pesanans_status_index', $indexes)) {
                $table->dropIndex('pesanans_status_index');
            }
            if (in_array('pesanans_tanggal_pemesanan_index', $indexes)) {
                $table->dropIndex('pesanans_tanggal_pemesanan_index');
            }
            
            if (Schema::hasColumn('pesanans', 'toko_id')) {
                $table->dropColumn('toko_id');
            }
            if (Schema::hasColumn('pesanans', 'total_harga')) {
                $table->dropColumn('total_harga');
            }
            if (Schema::hasColumn('pesanans', 'catatan_penjual')) {
                $table->dropColumn('catatan_penjual');
            }
        });

        DB::statement("ALTER TABLE pesanans MODIFY COLUMN status ENUM('pending', 'diproses', 'selesai') DEFAULT 'pending'");
    }

    private function getForeignKeys($table)
    {
        $keys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.TABLE_CONSTRAINTS 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = '{$table}' 
            AND CONSTRAINT_TYPE = 'FOREIGN KEY'
        ");
        
        return array_map(fn($key) => $key->CONSTRAINT_NAME, $keys);
    }

    private function getIndexes($table)
    {
        $indexes = DB::select("SHOW INDEX FROM {$table}");
        return array_unique(array_map(fn($index) => $index->Key_name, $indexes));
    }

    private function updateStatusEnum()
    {
        $result = DB::select("SHOW COLUMNS FROM pesanans WHERE Field = 'status'");
        $currentEnum = $result[0]->Type ?? '';
        
        if (strpos($currentEnum, 'dikonfirmasi') === false) {
            DB::statement("
                ALTER TABLE pesanans 
                MODIFY COLUMN status ENUM(
                    'pending', 
                    'dikonfirmasi', 
                    'diproses', 
                    'dikirim', 
                    'selesai', 
                    'dibatalkan'
                ) DEFAULT 'pending'
            ");
            echo "  ✓ Status enum diupdate\n";
        } else {
            echo "  ✓ Status enum sudah lengkap\n";
        }
    }
};