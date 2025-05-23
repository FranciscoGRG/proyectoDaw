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
        Schema::create('favorite_clothes', function (Blueprint $table) {
            $table->id();

            $table->json('camiseta');
            $table->json('pantalon');
            $table->json('zapatos');
            $table->integer('creador');
            $table->integer('outfit_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorite_clothes');
    }
};
