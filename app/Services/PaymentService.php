<?php

namespace App\Services;

use Illuminate\Http\Request;
use Validator;
use Input;
use Auth;
use App\User;
use App\Subscription;
use Stripe\Error\Card;
use Cartalyst\Stripe\Stripe;
use Carbon\Carbon;
use Log;
use Mail;
use Illuminate\Support\Facades\Cache;

class PaymentService
{

    public function process($data)
    {

    	// Get user
    	$user = Auth::user();

    	Log::info('Got payment processing in service');

		// Parse info and get Stripe user
		$stripe = Stripe::make(config('stripe.secret'));

		// First we need a user if we don't already have onew
		if(is_null($user->stripe_id)) {

			$stripeUser = $stripe->customers()
									->create([
										'email' => $user->email
									]);

			$user->stripe_id = $stripeUser['id'];

			$user->save();

		}

		try {
			
			// Create card by creating token, then card
			$token = $stripe->tokens()->create([
				'card' => [
					'number' => $data['card_no'],
					'exp_month' => $data['card_month'],
					'exp_year' => $data['card_year'],
					'cvc' => $data['card_cvv'],
				],
			]);

			Log::info('Created a token');
		
			if (!isset($token['id'])) {

				return array(
					'error' => 'Credit card invalid'
				);

			}

			// Here we create the card for the customer
			$card = $stripe->cards()
							->create(
								$user->stripe_id,
								$token['id']
							);

			// Create it
			// Let's get a trial date
			$trialDays = 0;

			$sendData = [
				'plan' => config('stripe.plan'),
				'quantity' => 1,
			];

			$charge = $stripe->subscriptions()->create(
				$user->stripe_id,
				$sendData
			);


			Log::info('Created charge: ' . print_r($charge, TRUE));

			if($charge['status'] == 'succeeded' || $charge['status'] == 'trialing') {

				Log::info('Charge succeeded');

				// Then we need to put the data in for the user
				$subscription = Subscription::create([
					'user_id'		=> $user->id,
					'name'			=> $charge['plan']['name'],
					'stripe_id'		=> $charge['id'],
					'stripe_plan'	=> $charge['plan']['id'],
				]);

				$user->update(['tier' => 'paid']);
				
				return array(
					'success' => $subscription
				);

			} else {

				Log::info('ERROR: ' . print_r($charge['status']));
				
				return array(
					'error' => print_r($charge['status'])
				);

			}

		} catch (Exception $e) {

			Log::info('ERROR exception: ' . print_r($e->getMessage(), TRUE));

			return array(
				'error' => $e->getMessage()
			);

		} catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {

			Log::info('ERROR CardErrorException: ' . print_r($e->getMessage(), TRUE));

			return array(
				'error' => $e->getMessage()
			);

		} catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {

			Log::info('ERROR MissingParameterException: ' . print_r($e->getMessage(), TRUE));

			return array(
				'error' => $e->getMessage()
			);

		}

	}

}