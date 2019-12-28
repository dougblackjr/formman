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

        $response = $this->service->create($form, $request);

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
}
