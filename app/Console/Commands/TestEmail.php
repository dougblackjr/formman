<?php

namespace App\Console\Commands;

use App\Form;
use App\Events\NewResponse;
use App\Mail\NewResponseMail;
use App\Response;
use Illuminate\Console\Command;
use Mail;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $form = Form::first();

        if(!$form) {

            $this->error('What? No forms!');

            die();

        }

        $data = [
            'name'  => 'Ryan Reynolds',
            'email' => 'test@formman.co',
            'words' => $this->createBiglyText(),
        ];

        $response = Response::create([
            'form_id'       => $form->id,
            'ip_address'    => '127.0.0.1',
            'data'          => $data,
            'is_spam'       => false,
            'is_active'     => true,
        ]);

        event(new NewResponse($response));

        $response->delete();

        $this->info('Donezo!');
    }

    private function createBiglyText()
    {

        $text = <<<TEX
BIG WORDS!
THEY'RE EVEERYHWERE\r\n
I EVEN PUTT DAT HTML IN DDDDDEERRRRRR
TEX;

        return $text;

    }
}
