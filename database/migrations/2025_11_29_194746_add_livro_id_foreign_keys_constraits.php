<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('escrito', function (Blueprint $table) {
            $table->dropForeign(['livro_id']);

            $table->foreign('livro_id')
                ->references('id')->on('livro')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('publicado', function (Blueprint $table) {
            $table->dropForeign(['livro_id']);

            $table->foreign('livro_id')
                ->references('id')->on('livro')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('escrito', function (Blueprint $table) {
            $table->dropForeign(['livro_id']);

            $table->foreign('livro_id')
                ->references('id')->on('livro');
        });

        Schema::table('publicado', function (Blueprint $table) {
            $table->dropForeign(['livro_id']);

            $table->foreign('livro_id')
                ->references('id')->on('livro');
        });
    }
};
