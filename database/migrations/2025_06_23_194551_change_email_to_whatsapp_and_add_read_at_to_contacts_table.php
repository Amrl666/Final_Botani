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
        Schema::table('contacts', function (Blueprint $table) {
            if (Schema::hasColumn('contacts', 'email')) {
                $table->string('whatsapp')->after('name')->nullable();
                $table->timestamp('read_at')->nullable()->after('message');
                $table->dropColumn('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            if (!Schema::hasColumn('contacts', 'email')) {
                $table->string('email')->after('name')->nullable();
                $table->dropColumn('whatsapp');
                $table->dropColumn('read_at');
            }
        });
    }
};
