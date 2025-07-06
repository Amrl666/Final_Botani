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
        Schema::table('products', function (Blueprint $table) {
            $table->string('unit')->default('kg')->after('price');
            $table->decimal('min_increment', 8, 2)->default(0.5)->after('unit');
            $table->integer('bundle_quantity')->nullable()->after('min_increment');
            $table->decimal('bundle_price', 10, 2)->nullable()->after('bundle_quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['unit', 'min_increment', 'bundle_quantity', 'bundle_price']);
        });
    }
};