<?php

// PerguntaFormularioFeedbackProduto.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PerguntaFormularioFeedbackProduto extends Model
{
    protected $table = 'pergunta_formulario_feedback_produto';
    protected $fillable = ['id_formulario', 'id_pergunta'];

    public function pergunta()
    {
        return $this->belongsTo(Pergunta::class, 'id_pergunta');
    }

    public function respostas()
    {
        return $this->hasMany(RespostaFormularioFeedbackProduto::class, 'id_pergunta_formulario_feedback_produto');
    }
}