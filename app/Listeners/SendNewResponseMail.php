<?php

namespace App\Listeners;

use App\Form;
use App\Response;
use App\Events\NewResponse;
use App\Mail\NewResponseMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;
use Mail;

class SendNewResponseMail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewResponse  $event
     * @return void
     */
    public function handle(NewResponse $event)
    {

        $response = $event->response;

        $response->load('form');

        Log::info('Got new response event: ' . $response->id);

        if(!$response->is_spam && $response->form->notify_by_email) {

            try {

                Mail::to($form->email)->send(new NewResponseMail($form, $response));

            } catch (\Swift_RfcComplianceException $e) {
                Log::error('Error sending response for form ID: ' . $response->form->id . ' and response ID: ' . $response->id);
                Log::error('ERROR: ' . print_r($e->getMessage(), true));
            } catch (\ErrorException $e) {
                Log::error('Error sending response for form ID: ' . $response->form->id . ' and response ID: ' . $response->id);
                Log::error('ERROR: ' . print_r($e->getMessage(), true));
            } catch (\Swift_TransportException $e) {
                Log::error('Error sending response for form ID: ' . $response->form->id . ' and response ID: ' . $response->id);
                Log::error('ERROR: ' . print_r($e->getMessage(), true));
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                Log::error('Error sending response for form ID: ' . $response->form->id . ' and response ID: ' . $response->id);
                Log::error('ERROR: ' . print_r($e->getMessage(), true));
            } catch (\Symfony\Component\Debug\Exception\FatalThrowableError $e) {
                Log::error('Error sending response for form ID: ' . $response->form->id . ' and response ID: ' . $response->id);
                Log::error('ERROR: ' . print_r($e->getMessage(), true));
            }

        } else {
            Log::info('Form: ' . ($response->form->notify_by_email ? 'YEP' : 'NOPE') . ' and SPAM: ' . $response->is_spam);
        }

    }
}
