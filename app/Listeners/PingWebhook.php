<?php

namespace App\Listeners;

use App\Events\NewResponse;
use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;

class PingWebhook
{

    protected $client;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

        $this->client = new Client();

    }

    /**
     * Handle the event.
     *
     * @param  NewResponse  $event
     * @return void
     */
    public function handle($event)
    {
        $response = $event->response;

        $response->load('form');

        if($response->form->webhook_url) {

            try {
                $response = $client->request(
                    'POST',
                    $response->form->webhook_url,
                    $response->toJson()
                );
            } catch (\Swift_RfcComplianceException $e) {
                Log::error('Error sending webhook for form ID: ' . $response->form->id . ' and response ID: ' . $response->id);
                Log::error('ERROR: ' . print_r($e->getMessage(), true));
            } catch (\ErrorException $e) {
                Log::error('Error sending webhook for form ID: ' . $response->form->id . ' and response ID: ' . $response->id);
                Log::error('ERROR: ' . print_r($e->getMessage(), true));
            } catch (\Swift_TransportException $e) {
                Log::error('Error sending webhook for form ID: ' . $response->form->id . ' and response ID: ' . $response->id);
                Log::error('ERROR: ' . print_r($e->getMessage(), true));
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                Log::error('Error sending webhook for form ID: ' . $response->form->id . ' and response ID: ' . $response->id);
                Log::error('ERROR: ' . print_r($e->getMessage(), true));
            } catch (\Symfony\Component\Debug\Exception\FatalThrowableError $e) {
                Log::error('Error sending webhook for form ID: ' . $response->form->id . ' and response ID: ' . $response->id);
                Log::error('ERROR: ' . print_r($e->getMessage(), true));
            }

        }
    }
}
