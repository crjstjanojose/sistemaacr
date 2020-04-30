<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use stdClass;

class SolicitacaoMail extends Mailable
{
    use Queueable, SerializesModels;
    private $parametros;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(stdClass $parametros)
    {
        $this->parametros = $parametros;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Nova Solicitação Enviada');
        $this->to($this->parametros->email, $this->parametros->name);
        return $this->view('paginas.alertas.solicitacaomail',[
            'parametros' => $this->parametros
        ]);
    }
}
