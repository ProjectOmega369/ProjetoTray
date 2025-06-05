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
        Schema::table('pergunta_formulario_feedback_produto', function (Blueprint $table) {
            $table->foreign(['id_formulario'], 'pergunta_formulario_feedback_produto_ibfk_1')->references(['id'])->on('formulario_feedback_produto')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_pergunta'], 'pergunta_formulario_feedback_produto_ibfk_2')->references(['id'])->on('pergunta')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pergunta_formulario_feedback_produto', function (Blueprint $table) {
            $table->dropForeign('pergunta_formulario_feedback_produto_ibfk_1');
            $table->dropForeign('pergunta_formulario_feedback_produto_ibfk_2');
        });
    }
};
