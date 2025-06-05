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
        Schema::table('compra', function (Blueprint $table) {
            $table->foreign(['id_comprador'], 'compra_ibfk_1')->references(['id'])->on('usuario')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_produto'], 'compra_ibfk_2')->references(['id'])->on('produto')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compra', function (Blueprint $table) {
            $table->dropForeign('compra_ibfk_1');
            $table->dropForeign('compra_ibfk_2');
        });
    }
};
