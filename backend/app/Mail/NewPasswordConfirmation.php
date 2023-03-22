<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPasswordConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    private array $mailData;

    /**
     * @param array $mailData
     */
    public function __construct(array $mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * @return static
     */

    public function build(): static
    {
        return $this
            ->from('sender@social.mg.gov.br', 'Siscap - Sede Social')
            ->subject( 'SISCAP Sedese Social  - Nova senha')
            ->markdown('newpasswordconfirmation')
            ->with([
                'email' => $this->mailData['email'],
                'name' => $this->mailData['name'],
            ]);
    }
}
