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
        Schema::table('resposta_formulario_feedback_produto', function (Blueprint $table) {
            $table->foreign(['id_pergunta_formulario_feedback_produto'], 'resposta_formulario_feedback_produto_ibfk_1')->references(['id'])->on('pergunta_formulario_feedback_produto')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resposta_formulario_feedback_produto', function (Blueprint $table) {
            $table->dropForeign('resposta_formulario_feedback_produto_ibfk_1');
        });
    }
};
