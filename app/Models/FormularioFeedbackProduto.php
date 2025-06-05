<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FormularioFeedbackProduto extends Model
{
    protected $table = 'formulario_feedback_produto';
    protected $fillable = ['id_compra', 'finalizado', 'data_envio'];

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'id_compra');
    }

    public function perguntasRespostas()
    {
        return $this->hasManyThrough(
            RespostaFormularioFeedbackProduto::class,
            PerguntaFormularioFeedbackProduto::class,
            'id_formulario', // FK em pergunta_formulario_feedback_produto
            'id_pergunta_formulario_feedback_produto', // FK em resposta_formulario_feedback_produto
            'id', // PK formulario_feedback_produto
            'id' // PK pergunta_formulario_feedback_produto
        )->with('pergunta');
    }
    public function respostas()
{
    return $this->hasMany(RespostaFormularioFeedbackProduto::class, 'id_formulario_feedback_produto');
}

public function usuario()
{
    return $this->belongsTo(User::class, 'id_usuario');
}


}
