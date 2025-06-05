<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;

class CompraController extends Controller
{
    public function compraAtual(Request $request)
    {
        $email = $request->user()->email ?? $request->query('email');

        if (!$email) {
            return response()->json(['error' => 'Email não fornecido'], 400);
        }

        $compra = Compra::whereHas('usuario', function ($q) use ($email) {
            $q->where('email', $email);
        })->latest()->first();

        if (!$compra) {
            return response()->json(['message' => 'Nenhuma compra encontrada.'], 404);
        }

        return response()->json([
            'id_compra' => $compra->id,
            'data' => $compra
        ]);
    }
}
