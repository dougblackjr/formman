<?php

namespace App\Http\Controllers;

use App\Form;
use App\Response;
use App\Services\ResponseService;
use App\User;
use Illuminate\Http\Request;

class ResponseController extends Controller
{

    protected $service;

    public function __construct()
    {

        $this->service = new ResponseService();

        $this->middleware(['auth'])->except('store');

    }

    /**
     * used to create form submission
     * @param  Request $request
     * @param  string  $slug
     * @return json
     */
    public function store(Request $request, string $slug)
    {

        $form = Form::bySlug($slug)->first();

        if( ! $form ) {
            return $request->wantsJSON()
                ? response()->json($request->all())
                : ($request->redirect)
                    ? redirect($request->redirect)
                    : redirect()->back();
        }

        $response = $this->service->create($form, $request);

        return $request->wantsJSON()
                ? response()->json($request->all())
                : ($request->redirect)
                    ? redirect($request->redirect)
                    : redirect()->back();

    }

    public function storeFromHook(Request $request, string $slug)
    {

        $secret = $request->incoming;

        $form = Form::bySlug($slug)
                        ->bySecret($secret)
                        ->first();

        if( ! $secret || ! $form ) {
            return $request->wantsJSON()
                ? response()->json($request->all())
                : ($request->redirect)
                    ? redirect($request->redirect)
                    : redirect()->back();
        }

        $response = $this->service->create($form, $request, $true);

        return response()->json($request->all());

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function show(Response $response)
    {

        return response()->json($response);

    }

    public function archive(Response $response)
    {

        $response->update(['is_active' => !$response->is_active]);

        return response()->json($response);

    }

    public function delete(Response $response)
    {

        $response->update(['is_active' => false]);

        $response->delete();

        return response()->json($response);

    }
}
