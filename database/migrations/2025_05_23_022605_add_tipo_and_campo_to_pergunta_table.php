<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pergunta', function (Blueprint $table) {
            $table->string('tipo')->after('id')->nullable();   // "estrela" ou "sim_nao"
            $table->string('campo')->after('tipo')->nullable(); // "compra", "pagamento", etc.
        });
    }

    public function down(): void
    {
        Schema::table('pergunta', function (Blueprint $table) {
            $table->dropColumn(['tipo', 'campo']);
        });
    }
};

