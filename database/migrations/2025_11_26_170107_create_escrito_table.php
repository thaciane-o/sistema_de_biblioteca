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
        Schema::create('escrito', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('autor_id');
            $table->foreign('autor_id')->references('id')->on('autor');
            $table->unsignedBigInteger('livro_id');
            $table->foreign('livro_id')->references('id')->on('livro');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('escrito', function (Blueprint $table) {
            $table->dropForeign(['autor_id']);
            $table->dropForeign(['livro_id']);
        });

        Schema::dropIfExists('escrito');
    }
};
