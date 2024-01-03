<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecoverPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this
            ->from('sender@social.mg.gov.br', 'Siscap - Sede Social')
            ->subject( 'SISCAP Sedese Social  - Recuperar senha')
            ->markdown('recoverpassword')
            ->with([
                'email' => $this->mailData['email'],
                'name' => $this->mailData['name'],
                'token' => $this->mailData['token'],
                'cpf' => $this->mailData['cpf'],
            ]);
    }
}
