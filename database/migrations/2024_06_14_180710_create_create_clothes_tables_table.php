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
        Schema::create('create_clothes_tables', function (Blueprint $table) {
            $table->id();

            $table->string('nombre');
            $table->string('genero');
            $table->string('tipo');
            $table->string('largo');
            $table->string('color');
            $table->float('precio');
            $table->string('img');
            $table->string('url');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('create_clothes_tables');
    }
};
