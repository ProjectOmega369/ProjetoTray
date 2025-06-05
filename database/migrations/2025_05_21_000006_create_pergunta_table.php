<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pergunta', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pergunta');
            $table->string('tipo_resposta', 20);
            $table->integer('valor_inteiro')->nullable();
            $table->boolean('valor_booleano')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pergunta');
    }
};

