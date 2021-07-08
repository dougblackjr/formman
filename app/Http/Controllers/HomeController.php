<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Form;
use App\Response;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user()->id;

        $plan = User::find($user)->tier;
        $forms = Form::where('user_id', $user)->pluck('id');
       
        
        

        if($plan == "paid") {
            $forms = Form::where('user_id', $user)
            ->orderBy('id', 'DESC')
            ->get();

        } else {
            $forms = Form::where('user_id', $user)
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->get();
        }

        $responses = Response::whereIn('form_id', $forms)->get();
       
        foreach($responses as $response) {
            //return $response->form->name;
        }



        
        
        
        return view('home', compact('plan', 'forms'));
    }

    public function upgrade()
    {

        $user = Auth::user();

    }

}
