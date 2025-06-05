<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreRespostaFormularioFeedbackProdutoRequest;
use App\Services\RespostaFormularioFeedbackProdutoService;

class RespostaFormularioFeedbackProdutoController extends Controller
{
    protected $service;

    public function __construct(RespostaFormularioFeedbackProdutoService $service)
    {
        $this->service = $service;
    }

    public function store(StoreRespostaFormularioFeedbackProdutoRequest $request)
    {
        $this->service->store($request->validated());

        return response()->json(['message' => 'Feedback enviado com sucesso!'], 201);
    }
}
