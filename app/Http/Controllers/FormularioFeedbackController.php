<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackRequest;
use App\Services\FormularioFeedbackService;
use Illuminate\Http\JsonResponse;

class FormularioFeedbackController extends Controller
{
    protected $service;

    public function __construct(FormularioFeedbackService $service)
    {
        $this->service = $service;
    }

    public function registrarFeedback(FeedbackRequest $request): JsonResponse
    {
        $this->service->salvarFeedback($request->validated());
        return response()->json(['message' => 'Feedback registrado com sucesso!']);
    }
}
