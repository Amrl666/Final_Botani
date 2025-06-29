<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('wishlists', function (Blueprint $table) {
            if (!Schema::hasColumn('wishlists', 'customer_id')) {
                $table->foreignId('customer_id')->after('id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('wishlists', 'product_id')) {
                $table->foreignId('product_id')->after('customer_id')->constrained()->onDelete('cascade');
            }
            $table->unique(['customer_id', 'product_id']);
        });
    }
    public function down()
    {
        Schema::table('wishlists', function (Blueprint $table) {
            $table->dropUnique(['customer_id', 'product_id']);
            if (Schema::hasColumn('wishlists', 'customer_id')) {
                $table->dropForeign(['customer_id']);
                $table->dropColumn('customer_id');
            }
            if (Schema::hasColumn('wishlists', 'product_id')) {
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
            }
        });
    }
}; 