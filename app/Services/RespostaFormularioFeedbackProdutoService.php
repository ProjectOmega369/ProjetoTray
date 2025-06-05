<?php
// app/Services/RespostaFormularioFeedbackProdutoService.php

namespace App\Services;

use App\Models\RespostaFormularioFeedbackProduto;
use Illuminate\Support\Facades\DB;

class RespostaFormularioFeedbackProdutoService
{
    public function store(array $data)
    {
        DB::transaction(function () use ($data) {
            foreach ($data['respostas'] as $resposta) {
                RespostaFormularioFeedbackProduto::create([
                    'id_formulario_feedback_produto' => $data['id_formulario_feedback_produto'],
                    'id_pergunta' => $resposta['id_pergunta'],
                    'resposta' => $resposta['resposta'],
                ]);
            }
        });
    }
}
