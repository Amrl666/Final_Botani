<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemesan');
            $table->string('telepon');
            $table->string('alamat')->nullable();
            $table->integer('jumlah_orang')->nullable();
            $table->date('tanggal_kunjungan')->nullable();
            $table->foreignId('produk_id')->nullable()->constrained('products')->onDelete('set null');
            $table->foreignId('eduwisata_id')->nullable()->constrained('eduwisatas')->onDelete('set null');
            $table->decimal('total_harga', 10, 2)->nullable();
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'selesai'])->default('menunggu');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
