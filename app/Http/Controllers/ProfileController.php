<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = User::find(Auth::user()->id);
        $name = explode(' ', $user->name);
        return view('profile.index', compact('user', 'name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $firstName = $request->firstName;
        $lastName = $request->lastName;
        $email = $request->email;
        $pass = $request->password;
        $passAgain = $request->password_again;

        //if passwords do not match
        if($pass != $passAgain) {

            //return failed message
            return redirect()->route('profile')->with('failed', 'Passwords did not match!');
        } else {
            //they match
            $user = User::find(Auth::user()->id);
            $user->name = "{$firstName} {$lastName}";
            $user->email = $email;

            //check if password fields are not empty
            if(!empty($pass) && !empty($passAgain)) {
                $user->password = Hash::make($passAgain);
            }

            $user->save();
        }

        return redirect()->route('profile')->with('success', 'Successfully Updated Profile Information');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
