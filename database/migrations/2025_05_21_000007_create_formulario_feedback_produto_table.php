<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formulario_feedback_produto', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_compra')->nullable()->index('id_compra');
            $table->boolean('finalizado')->nullable();
            $table->date('data_envio')->nullable();
            $table->timestamps();

            $table->foreign('id_compra')->references('id')->on('compra')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formulario_feedback_produto');
    }
};
