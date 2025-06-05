<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class AuthController extends Controller
{

public function login(Request $request)
{
    $email = $request->input('email');
    $nome = $request->input('nome');

    $usuario = Usuario::where('email', $email)->where('nome', $nome)->first();

    if (!$usuario) {
        return response()->json(['message' => 'Usuário não encontrado'], 404);
    }

    // Gera token via Sanctum
     $token = $usuario->createToken('token-usuario')->plainTextToken;

    return response()->json([
        'message' => 'Login realizado com sucesso',
        'usuario' => $usuario,
        'token' => $token
    ]);
}



}
