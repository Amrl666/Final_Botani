<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemesan');
            $table->string('telepon');
            $table->integer('jumlah_orang')->nullable();
            $table->foreignId('produk_id')->nullable()->constrained('products')->onDelete('set null');
            $table->foreignId('eduwisata_id')->nullable()->constrained('eduwisatas')->onDelete('set null');
            $table->integer('total_harga')->nullable();
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'selesai'])->default('menunggu');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('orders');
    }
};
