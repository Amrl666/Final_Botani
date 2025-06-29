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
        // Update enum values for status column
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('menunggu', 'menunggu_konfirmasi', 'disetujui', 'ditolak', 'selesai') DEFAULT 'menunggu'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('menunggu', 'disetujui', 'ditolak', 'selesai') DEFAULT 'menunggu'");
    }
};
