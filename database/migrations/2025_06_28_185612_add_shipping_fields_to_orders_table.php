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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('shipping_address_id')->nullable()->after('alamat')->constrained()->onDelete('set null');
            $table->decimal('shipping_cost', 10, 2)->default(0)->after('total_harga');
            $table->enum('delivery_method', ['pickup', 'delivery'])->default('pickup')->after('shipping_cost');
            $table->timestamp('estimated_delivery')->nullable()->after('delivery_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['shipping_address_id']);
            $table->dropColumn(['shipping_address_id', 'shipping_cost', 'delivery_method', 'estimated_delivery']);
        });
    }
};
