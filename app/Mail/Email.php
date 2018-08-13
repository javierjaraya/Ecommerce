<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Email extends Mailable
{
    use Queueable, SerializesModels;


    public $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->email->destinatario)//Destinatario
                    ->view('mails.email_pedido_entregado')//Texto html
                    ->text('mails.email_plain');//Texto plano
                    /*->with(
                      [
                            'testVarOne' => '1',
                            'testVarTwo' => '2',
                      ]);*/
                      /*->attach(public_path('/images').'/demo.jpg', [
                              'as' => 'demo.jpg',
                              'mime' => 'image/jpeg',
                      ]);*///Para adjuntar una imagen
    }
}
