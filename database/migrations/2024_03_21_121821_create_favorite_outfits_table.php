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
        Schema::create('favorite_outfits', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('footwear');
            $table->string('trousers');
            $table->string('Tshirt');
            $table->string('coat')->nullable();
            $table->string('complements')->nullable(); //Array de complementos
            $table->string('images')->nullable();

            $table->timestamps();

            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorite_outfits');
    }
};
