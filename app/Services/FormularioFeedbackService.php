<?php
namespace App\Services;

use App\Models\FormularioFeedbackProduto;
use App\Models\RespostaFormularioFeedbackProduto;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class FormularioFeedbackService
{
    public function salvarFeedback(array $dados): void
    {
        DB::transaction(function () use ($dados) {
            $usuario = User::where('email', $dados['email'])->first();

            $formulario = FormularioFeedbackProduto::create([
                'id_usuario' => $usuario->id,
                'id_compra' => $dados['id_compra'],
                'comentario_suporte' => $dados['comentario_suporte'] ?? null
            ]);

            foreach ($dados['respostas'] as $resposta) {
                RespostaFormularioFeedbackProduto::create([
                    'id_formulario_feedback_produto' => $formulario->id,
                    'id_pergunta' => $resposta['id_pergunta'],
                    'avaliacao' => $resposta['avaliacao']
                ]);
            }
        });
    }
}