<?php

namespace App\Http\Controllers;

use App\Models\Pergunta;
use Illuminate\Http\JsonResponse;

class PerguntaController extends Controller
{
    // Retorna todas as perguntas
    public function index(): JsonResponse
    {
        $perguntas = Pergunta::select('id', 'pergunta', 'campo', 'tipo', 'tipo_resposta')->get();
        return response()->json($perguntas);
    }
}
