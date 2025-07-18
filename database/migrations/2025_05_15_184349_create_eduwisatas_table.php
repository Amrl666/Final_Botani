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
        Schema::create('eduwisatas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('harga', 10, 2);
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('eduwisata_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eduwisata_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->time('time');   
            $table->integer('max_participants');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eduwisata_schedules');
        Schema::dropIfExists('eduwisatas');
    }
};
