<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    protected $table = 'configuracao';

    protected $fillable = [
        'id_loja',
        'delay_enviar_email',
        // outros campos de configuração que desejar
    ];

    // Relação com a loja
    public function loja()
    {
        return $this->belongsTo(Loja::class, 'id_loja');
    }
}
