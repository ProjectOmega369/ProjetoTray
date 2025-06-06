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
    Schema::table('compra', function (Blueprint $table) {
        $table->boolean('email_enviado')->default(false);
    });
}

public function down()
{
    Schema::table('compra', function (Blueprint $table) {
        $table->dropColumn('email_enviado');
    });
}

};
