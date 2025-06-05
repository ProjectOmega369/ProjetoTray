<?php

namespace App\Models;
use App\Models\Loja;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produto';

    protected $fillable = ['nome', 'descricao', 'valor'];

    public $timestamps = false;

    // Relacionamentos, se quiser, exemplo com compras:
    public function compras()
    {
        return $this->hasMany(Compra::class, 'id_produto');
    }
    public function loja()
    {
    return $this->belongsTo(Loja::class, 'id_loja'); // Se tiver esse relacionamento
    }

}
