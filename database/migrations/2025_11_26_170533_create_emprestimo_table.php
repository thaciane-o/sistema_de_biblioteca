<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('emprestimo', function (Blueprint $table) {
            $table->id();
            $table->double('valorPraticado');
            $table->date('dataInicio');
            $table->date('dataFimEsperado');
            $table->date('dataFimReal')->nullable();
            $table->integer('renovacoes')->nullable();
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('cliente');
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
        Schema::table('emprestimo', function (Blueprint $table) {
            $table->dropForeign(['cliente_id']);
            $table->dropForeign(['livro_id']);
        });

        Schema::dropIfExists('emprestimo');
    }
};
