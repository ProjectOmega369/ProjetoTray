<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:usuario,email',
            'id_compra' => 'required|exists:compra,id',
            'respostas' => 'required|array|min:1',
            'respostas.*.id_pergunta' => 'required|exists:pergunta,id',
            'respostas.*.avaliacao' => 'required',
            'comentario_suporte' => 'nullable|string'
        ];
    }
}