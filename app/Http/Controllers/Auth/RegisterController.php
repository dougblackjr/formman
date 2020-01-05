<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\PaymentService;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'tier' => ['required'],
            'card_number'   => Rule::requiredIf(function () use ($data) {
                                    return $data['tier'] === 'paid';
                                }),
            'card_exp'      => Rule::requiredIf(function () use ($data) {
                                    return $data['tier'] === 'paid';
                                }),
            'card_cvc'      => Rule::requiredIf(function () use ($data) {
                                    return $data['tier'] === 'paid';
                                }),
            'card_zip'      => Rule::requiredIf(function () use ($data) {
                                    return $data['tier'] === 'paid';
                                }),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'tier' => $data['tier'],
        ]);

        if($data['tier'] == 'paid') {

            $service = new PaymentService();

            // Parse expiration
            $date = explode('/', $data['card_exp']);

            $result = $service->process(
                [
                    'card_no'   => $data['card_number'],
                    'card_month'    => trim($date[0]),
                    'card_year' => trim($date[1]),
                    'card_cvv'  => $data['card_cvc'],
                ]
            );

            if(!isset($result['error'])) {
                $user->update(['tier' => 'free']);
            }

        }

        return $user;
    }
}
