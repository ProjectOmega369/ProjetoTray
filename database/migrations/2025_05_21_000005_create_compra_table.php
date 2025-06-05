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
        Schema::create('compra', function (Blueprint $table) {
            $table->increments('id');
            $table->date('data_compra')->nullable();
            $table->date('data_finalizacao')->nullable();
            $table->unsignedInteger('id_comprador')->index('id_comprador');
            $table->unsignedInteger('id_produto')->index('id_produto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compra');
    }
};
