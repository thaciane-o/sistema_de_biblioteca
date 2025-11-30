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
        Schema::table('responsavel_emprestimo', function (Blueprint $table) {
            $table->dropForeign(['emprestimo_id']);

            $table->foreign('emprestimo_id')
                ->references('id')->on('emprestimo')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('responsavel_emprestimo', function (Blueprint $table) {
            $table->dropForeign(['emprestimo_id']);

            $table->foreign('emprestimo_id')
                ->references('id')->on('emprestimo');
        });
    }
};
