<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pergunta extends Model
{
    protected $table = 'pergunta';
    protected $fillable = ['pergunta', 'tipo_resposta', 'valor_inteiro', 'valor_booleano'];
}

