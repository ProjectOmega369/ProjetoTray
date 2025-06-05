<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeedbackLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public $compra;

    public function __construct($compra)
    {
        $this->compra = $compra;
    }

    public function build()
    {
        return $this->subject('Feedback da sua compra')
                    ->view('emails.feedback_link')
                    ->with([
                        'linkFormulario' => url("/feedback/form/{$this->compra->id}"),
                        'usuarioNome' => $this->compra->usuario->nome,
                        'produtoNome' => $this->compra->produto->nome,
                    ]);
    }
}
