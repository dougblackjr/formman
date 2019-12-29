<?php

namespace App\Services;

use App\Form;
use App\Mail\NewResponseMail;
use App\Response;
use Illuminate\Http\Request;
use Mail;

class ResponseService extends BaseService {

	public function __construct()
	{

	}

	public function create(Form $form, Request $request)
	{

		$isSpam = $this->isSpam($request);

		$data = $this->parseData($request);

		$response = Response::create([
			'form_id'		=> $form->id,
		    'ip_address'	=> $request->ip(),
			'data'			=> $data,
			'is_spam'		=> $isSpam,
			'is_active'		=> !$isSpam,
		]);

	}

	private function formIsActive($form)
	{

		return $form->enabled;

	}

	private function parseData($request)
	{

		$data = clone $request;

		$json = $data->all();

		unset($json['important_checkbox']);

		return $json;

	}

	private function isSpam($request)
	{

		return $request->has('important_checkbox');

	}

}