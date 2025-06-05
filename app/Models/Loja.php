<?php

namespace App\Models;
use App\Models\loji;
use Illuminate\Database\Eloquent\Model;

class Loja extends Model
{
    protected $table = 'loja';

    protected $fillable = [
        'nome',
        'cnpj',
        'endereco',
        // Adicione aqui 'delay_enviar_email' se esse campo existir na tabela loja
        'delay_enviar_email',
        'id_lojista', // suposição que a loja tem um lojista vinculado por id_lojista
    ];

    // Relação com o lojista (um lojista tem uma loja)
    public function lojista()
    {
        return $this->belongsTo(Lojista::class, 'id_lojista');
    }

    // Relação com os produtos da loja (uma loja tem muitos produtos)
    public function produtos()
    {
        return $this->hasMany(Produto::class, 'id_loja');
    }

    // Relação com a configuração (caso exista tabela de configuração)
    public function configuracao()
    {
        return $this->hasOne(Configuracao::class, 'id_loja');
    }
}
