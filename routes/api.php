<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\PerguntaController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\FormularioFeedbackController;
use App\Http\Controllers\RespostaFormularioFeedbackProdutoController;

// Login (sem autenticação)
Route::post('/login', [AuthController::class, 'login']);

// Rotas públicas (sem autenticação)
Route::post('/feedback', [RespostaFormularioFeedbackProdutoController::class, 'store']); // envio de feedback
Route::get('/feedback/lojista/{id_lojista}/produto/{id_produto}', [FeedbackController::class, 'getFeedbacksByLojistaProduto']);
Route::get('/feedback/perguntas', [FeedbackController::class, 'listarPerguntas']);
Route::get('/perguntas', [PerguntaController::class, 'index']);

// Rotas protegidas (requer auth:sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Compra atual do usuário autenticado
    Route::get('/compra-atual', [CompraController::class, 'ultimaCompraUsuario']);

    // Registrar feedback com formulário
    Route::post('/registrar-feedback', [FormularioFeedbackController::class, 'registrarFeedback']);
});
