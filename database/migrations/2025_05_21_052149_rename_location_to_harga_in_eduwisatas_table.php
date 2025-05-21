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
        Schema::table('eduwisatas', function (Blueprint $table) {
              $table->renameColumn('location', 'harga');

    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eduwisatas', function (Blueprint $table) {
            $table->renameColumn('harga', 'location');
        });
    }
};
