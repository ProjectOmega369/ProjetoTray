<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Compra;
use App\Models\FormularioFeedbackProduto;
use App\Models\Pergunta;
use App\Models\PerguntaFormularioFeedbackProduto;
use App\Models\RespostaFormularioFeedbackProduto;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|max:255',
            'id_compra' => 'required|integer|exists:compra,id',
            'respostas' => 'required|array|min:1',
            'respostas.*.id_pergunta' => 'required|integer|exists:pergunta,id',
            'respostas.*.avaliacao' => 'required', // aceitamos string ou int, vamos validar depois
        ]);

        // Cria ou pega usuário pelo email
        $usuario = Usuario::firstOrCreate(
            ['email' => $data['email']]
        );

        // Verifica se a compra existe e pertence ao usuário
        $compra = Compra::where('id', $data['id_compra'])
                        ->where('id_comprador', $usuario->id)
                        ->first();

        if (!$compra) {
            return response()->json(['error' => 'Compra não encontrada ou não pertence ao usuário.'], 404);
        }

        // Cria o formulário de feedback
        $formulario = FormularioFeedbackProduto::create([
            'id_compra' => $compra->id,
            'finalizado' => true,
            'data_envio' => now(),
        ]);

        foreach ($data['respostas'] as $resp) {
            // Pega pergunta para validar tipo
            $pergunta = Pergunta::find($resp['id_pergunta']);
            if (!$pergunta) {
                return response()->json(['error' => 'Pergunta inválida: ' . $resp['id_pergunta']], 400);
            }

            // Cria vínculo pergunta_formulario
            $pfp = PerguntaFormularioFeedbackProduto::create([
                'id_formulario' => $formulario->id,
                'id_pergunta' => $pergunta->id,
            ]);

            // Define os campos de avaliação de acordo com o tipo da pergunta
            if ($pergunta->tipo_resposta === 'sim_nao') {
                $avaliacaoBinaria = null;
                $avaliacao = strtolower(trim($resp['avaliacao']));

                if (in_array($avaliacao, ['sim', 'true', '1'], true)) {
                    $avaliacaoBinaria = true;
                } elseif (in_array($avaliacao, ['nao', 'false', '0'], true)) {
                    $avaliacaoBinaria = false;
                } else {
                    return response()->json(['error' => "Resposta inválida para pergunta binária: {$resp['avaliacao']}"], 422);
                }

                RespostaFormularioFeedbackProduto::create([
                    'id_pergunta_formulario_feedback_produto' => $pfp->id,
                    'avaliacao_estrelas' => null,
                    'avaliacao_binaria' => $avaliacaoBinaria,
                ]);
            } elseif ($pergunta->tipo_resposta === 'estrela') {
                // Valida se é inteiro entre 1 e 5, por exemplo
                $avaliacaoEstrelas = intval($resp['avaliacao']);
                if ($avaliacaoEstrelas < 1 || $avaliacaoEstrelas > 5) {
                    return response()->json(['error' => "Avaliação por estrelas deve ser entre 1 e 5"], 422);
                }

                RespostaFormularioFeedbackProduto::create([
                    'id_pergunta_formulario_feedback_produto' => $pfp->id,
                    'avaliacao_estrelas' => $avaliacaoEstrelas,
                    'avaliacao_binaria' => null,
                ]);
            } else {
                // Aqui pode tratar outros tipos de resposta, se houver
                return response()->json(['error' => 'Tipo de resposta não suportado: ' . $pergunta->tipo_resposta], 422);
            }
        }

        return response()->json(['message' => 'Feedback enviado com sucesso']);
    }

    // Para o lojista ver feedbacks por produto e lojista
    public function getFeedbacksByLojistaProduto($id_lojista, $id_produto)
    {
        // Filtra formulários que pertencem a compras com o produto e que a loja pertence ao lojista
        $feedbacks = FormularioFeedbackProduto::whereHas('compra', function ($q) use ($id_produto, $id_lojista) {
            $q->where('id_produto', $id_produto)
              ->whereHas('produto', function($query) use ($id_lojista) {
                  $query->whereHas('loja', function($queryLoja) use ($id_lojista) {
                      $queryLoja->where('id_lojista', $id_lojista);
                  });
              });
        })->with([
            'compra',
            'compra.usuario',
            'perguntasRespostas' => function ($qr) {
                $qr->with('perguntaFormulario.pergunta');
            }
        ])->get();

        return response()->json($feedbacks);
    }
    public function compraAtual(Request $request)
{
    // Se seu sistema de autenticação não estiver configurado, pegue o token direto do header:
    $authHeader = $request->header('Authorization'); // "Bearer 5"

    if (!$authHeader) {
        return response()->json(['message' => 'Token não fornecido'], 401);
    }

    $token = str_replace('Bearer ', '', $authHeader);
    $userId = intval($token);

    if (!$userId) {
        return response()->json(['message' => 'Token inválido'], 401);
    }

    $compra = Compra::where('id_comprador', $userId)
                    ->where('status', 'aberta') // ou outra condição que defina "compra atual"
                    ->latest()
                    ->first();

    if (!$compra) {
        return response()->json(['message' => 'Compra atual não encontrada.'], 404);
    }

    return response()->json($compra);
    
}
public function listarPerguntas()
{
    $perguntas = Pergunta::all(['id', 'pergunta', 'tipo_resposta']);
    return response()->json($perguntas);
}


}
