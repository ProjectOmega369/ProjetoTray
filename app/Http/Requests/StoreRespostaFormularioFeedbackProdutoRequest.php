<?php

// app/Http/Requests/StoreRespostaFormularioFeedbackProdutoRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRespostaFormularioFeedbackProdutoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id_formulario_feedback_produto' => 'required|exists:formulario_feedback_produto,id',
            'respostas' => 'required|array',
            'respostas.*.id_pergunta' => 'required|exists:pergunta,id',
            'respostas.*.resposta' => 'required|string|max:255',
        ];
    }
}
