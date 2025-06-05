<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class RespostaFormularioFeedbackProduto extends Model
{
    protected $table = 'resposta_formulario_feedback_produto';
    protected $fillable = ['id_pergunta_formulario_feedback_produto', 'avaliacao_estrelas', 'avaliacao_binaria'];

    public function perguntaFormulario()
{
    return $this->belongsTo(PerguntaFormularioFeedbackProduto::class, 'id_pergunta_formulario_feedback_produto');
}

public function pergunta()
{
    return $this->belongsTo(Pergunta::class, 'id_pergunta');
}

public function formulario()
{
    return $this->belongsTo(FormularioFeedbackProduto::class, 'id_formulario_feedback_produto');
}





}