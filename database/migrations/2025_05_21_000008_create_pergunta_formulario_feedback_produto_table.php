<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('pergunta_formulario_feedback_produto', function (Blueprint $table) {
        $table->increments('id');  // Chave primária
        $table->unsignedInteger('id_formulario'); // Definindo como unsignedInteger
        $table->unsignedInteger('id_pergunta');  // Definindo como unsignedInteger para compatibilidade com pergunta.id
        $table->timestamps();

        // Definindo as chaves estrangeiras corretamente
        $table->foreign('id_formulario')
            ->references('id')->on('formulario_feedback_produto')
            ->onDelete('cascade');

        $table->foreign('id_pergunta')
            ->references('id')->on('pergunta')
            ->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::dropIfExists('pergunta_formulario_feedback_produto');
}

};
