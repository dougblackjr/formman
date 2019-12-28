<?php

namespace App\Http\Controllers;

use App\Form;
use App\Response;
use App\Requests\FormRequest;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = Auth::user();

        $forms = Form::byUser($user->id)->withCount('responses');

        return response()->json($forms);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormRequest $request)
    {

        $user = Auth::user();

        $form = Form::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'email' => $request->email,
            'slug' => Str::uuid()->toString(),
            'domain' => $request->domain,
            'enabled' => true,
            'notify_by_email' => $request->notify_by_email,
        ]);

        return response()->json($form);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {

        $this->authorize('read', $form);

        $form->load('responses');

        return view('forms.view', compact('form'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function update(FormRequest $request, Form $form)
    {

        $this->authorize('update', $form);

        $form->update($request->all());

        return response()->json($form);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function destroy(Form $form)
    {

        $this->authorize('delete', $form);

        $form->enabled = false;
        $form->save();
        $form->delete();

        return response()->json('ok');

    }

}
