<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pergunta;

class PerguntaSeeder extends Seeder
{
    public function run(): void
    {
        $perguntas = [
            [
                'tipo_resposta' => 'estrela',
                'pergunta' => 'Como você avalia sua experiência de compra?',
                'campo' => 'compra',
            ],
            [
                'tipo_resposta' => 'estrela',
                'pergunta' => 'Como você avalia a facilidade de navegação na loja?',
                'campo' => 'navegacao',
            ],
            [
                'tipo_resposta' => 'estrela',
                'pergunta' => 'Como você avalia o processo de pagamento?',
                'campo' => 'pagamento',
            ],
            [
                'tipo_resposta' => 'estrela',
                'pergunta' => 'Qual é a probabilidade de recomendar nossa loja?',
                'campo' => 'recomendacao',
            ],
            [
                'tipo_resposta' => 'estrela',
                'pergunta' => 'Como você avalia o cumprimento do prazo de entrega?',
                'campo' => 'prazo',
            ],
            [
                'tipo_resposta' => 'estrela',
                'pergunta' => 'Como você avalia a condição do produto ao chegar?',
                'campo' => 'condicao',
            ],
            [
                'tipo_resposta' => 'estrela',
                'pergunta' => 'Como você avalia o custo do frete?',
                'campo' => 'frete',
            ],
            [
                'tipo_resposta' => 'sim_nao',
                'pergunta' => 'Você precisou de suporte ou atendimento durante a compra?',
                'campo' => 'suporte',
            ],
            [
                'tipo_resposta' => 'estrela',
                'pergunta' => 'Se Sim, como você avalia sua experiência com o suporte?',
                'campo' => 'avaliacao_suporte',
            ],
            [
                'tipo_resposta' => 'sim_nao',
                'pergunta' => 'Você gostaria de ser contatado para suporte ou melhorias?',
                'campo' => 'contato',
            ],
        ];

        foreach ($perguntas as $pergunta) {
            Pergunta::create($pergunta);
        }
    }
}
