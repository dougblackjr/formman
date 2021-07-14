<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpgradeController extends Controller
{

	public function __construct()
	{

		$this->middleware('auth');

	}

	public function index() {
		$user = User::find(Auth::user()->id);

		return view('auth.upgrade', compact('user'));
	}

	public function menu() {
		return "Account Menu Here";
	}

	public function upgrade(Request $request)
	{

		$user = Auth::user();

		$validator = $request->validate([
            'card_number'   => 'required',
            'card_exp'      => 'required',
            'card_cvc'      => 'required',
            'card_zip'      => 'required',
        ]);

        $service = new PaymentService();

		// Parse expiration
		$date = explode('/', $request->card_exp);

		$result = $service->process(
		    [
		        'card_no'   => $request->card_number,
		        'card_month'    => trim($date[0]),
		        'card_year' => trim($date[1]),
		        'card_cvv'  => $request->card_cvc,
		    ]
		);

		if(!isset($result['error'])) {
		    $user->update(['tier' => 'free']);

		    $errors = [
		    	'There was a problem processing your payment.'
		    ];

		    return redirect('/upgrade')->withErrors($errors);
		}

		return redirect('/success');

	}
}