<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('loja', function (Blueprint $table) {
        $table->integer('delay_enviar_email')->default(3); // padrão 3 dias, por exemplo
    });
}

public function down()
{
    Schema::table('loja', function (Blueprint $table) {
        $table->dropColumn('delay_enviar_email');
    });
}

};
