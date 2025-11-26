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
        Schema::create('responsavel_emprestimo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emprestimo_id');
            $table->foreign('emprestimo_id')->references('id')->on('emprestimo');
            $table->unsignedBigInteger('responsavel_id');
            $table->foreign('responsavel_id')->references('id')->on('funcionario');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('responsavel_emprestimo', function (Blueprint $table) {
            $table->dropForeign(['responsavel_id']);
            $table->dropForeign(['emprestimo_id']);
        });

        Schema::dropIfExists('responsavel_emprestimo');
    }
};
