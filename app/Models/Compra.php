<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Compra extends Model
{
    protected $table = 'compra';

    protected $fillable = [
        'data_compra',
        'data_finalizacao',
        'id_comprador',
        'id_produto',
        'email_enviado', // se existir essa coluna para controle de envio
    ];

    // Diz ao Eloquent que esses campos são do tipo data e devem ser tratados como Carbon
    protected $dates = [
        'data_compra',
        'data_finalizacao',
        'created_at',
        'updated_at',
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'id_produto');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_comprador');
    }

    public function formularioFeedback()
    {
        return $this->hasOne(FormularioFeedbackProduto::class, 'id_compra');
    }

    // Exemplo de método customizado para verificar se já pode enviar email
    public function podeEnviarEmail(): bool
    {
        $hoje = Carbon::now()->startOfDay();

        // Supondo que a loja está acessível via produto->loja->configuracao
        $delay = $this->produto->loja->configuracao->delay_enviar_email ?? 0;

        $dataEnvio = Carbon::parse($this->data_finalizacao)->addDays($delay);

        return $dataEnvio->lte($hoje) && !$this->email_enviado;
    }
}
