<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resposta_formulario_feedback_produto', function (Blueprint $table) {
            $table->increments('id');
           $table->unsignedInteger('id_pergunta_formulario_feedback_produto')->index('idx_resposta_pergunta');
            $table->integer('avaliacao_estrelas')->nullable();
            $table->boolean('avaliacao_binaria')->nullable();
            $table->timestamps();

            // Definindo um nome curto para o constraint da chave estrangeira
            $table->foreign('id_pergunta_formulario_feedback_produto')
      ->references('id')
      ->on('pergunta_formulario_feedback_produto')
      ->onDelete('cascade')
      ->name('pergunta_formulario_feedback_produto_id_foreign');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resposta_formulario_feedback_produto');
    }
};
