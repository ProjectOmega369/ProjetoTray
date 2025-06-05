<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lojista extends Model
{
    protected $table = 'lojista';

    protected $fillable = [
        'nome',
        'email',
    ];

    // Relação com a loja (um lojista tem uma loja)
    public function loja()
    {
        return $this->hasOne(Loja::class, 'id_lojista');
    }
}
