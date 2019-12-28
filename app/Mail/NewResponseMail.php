<?php

namespace App\Mail;

use App\Form;
use App\Response;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $form;

    public $response;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Form $form, Response $response)
    {

        $this->form = $form;

        $this->response = $response;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->subject("You have a new response on {$this->form->name}")
                    ->markdown('mail.new-response');

    }

}
