<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // $table->text('alamat')->nullable()->after('telepon');
            // $table->integer('jumlah')->nullable()->after('jumlah_orang'); // jumlah produk (kg)
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // $table->dropColumn(['alamat', 'jumlah']);
        });
    }
};

