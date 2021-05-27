<?php

namespace App\Mail;

use App\EmailResponse;
use App\Form;
use App\Response;
use App\Services\TemplateService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewEmailResponse extends Mailable
{
    use Queueable, SerializesModels;

    public $form;
    public $response;
    public $emailResponse;
    public $body;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Form $form, Response $response, EmailResponse $emailResponse)
    {
        $this->form = $form;
        $this->response = $response;
        $this->emailResponse = $emailResponse;
        $this->body = TemplateService::parse($this->emailResponse->template, $this->response);
        $this->subject = TemplateService::parse($this->emailResponse->subject, $this->response);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->view('mail.email-response');
    }
}
