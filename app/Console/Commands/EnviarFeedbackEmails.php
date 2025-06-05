<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Compra;
use Illuminate\Support\Facades\Mail;

class EnviarFeedbackEmails extends Command
{
    protected $signature = 'feedback:enviar-emails';
    protected $description = 'Envia emails de feedback para compras finalizadas após delay';

    public function handle()
    {
        $hoje = now()->startOfDay();

        // Busca compras que ainda não receberam email, cuja data_finalizacao + delay <= hoje
        $compras = Compra::where('email_enviado', false)
            ->whereHas('produto.loja', function ($query) {
                $query->whereNotNull('delay_enviar_email');
            })
            ->get();

        foreach ($compras as $compra) {
            $delay = $compra->produto->loja->delay_enviar_email ?? 0;
            $dataEnvio = $compra->data_finalizacao->addDays($delay);

            if ($dataEnvio->lte($hoje)) {
                // Aqui você deve implementar o envio do email com link para o formulário
                Mail::to($compra->usuario->email)->send(new \App\Mail\FeedbackLinkMail($compra));

                $compra->email_enviado = true;
                $compra->save();

                $this->info("Email enviado para compra ID {$compra->id} - Usuário {$compra->usuario->email}");
            }
        }
    }
}
