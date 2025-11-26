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
        Schema::create('publicado', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('editora_id');
            $table->foreign('editora_id')->references('id')->on('editora');
            $table->unsignedBigInteger('livro_id');
            $table->foreign('livro_id')->references('id')->on('livro');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('publicado', function (Blueprint $table) {
            $table->dropForeign(['editora_id']);
            $table->dropForeign(['livro_id']);
        });

        Schema::dropIfExists('publicado');
    }
};
