<?php

namespace App\Services;

use App\Form;
use App\Mail\NewResponseMail;
use App\Response;
use Illuminate\Http\Request;
use Mail;
use Storage;

class ResponseService extends BaseService {

	public function __construct()
	{

	}

	public function create(Form $form, Request $request)
	{

		$isSpam = $this->isSpam($request);

		$data = $this->parseData($request, $form);

		$response = Response::create([
			'form_id'		=> $form->id,
		    'ip_address'	=> $request->ip(),
			'data'			=> $data,
			'is_spam'		=> $isSpam,
			'is_active'		=> !$isSpam,
		]);

		return $response;

	}

	private function formIsActive($form)
	{

		return $form->enabled;

	}

	private function parseData($request, $form)
	{

		$user = $form->user;

		$data = clone $request;

		$json = $data->all();

		unset($json['important_checkbox']);
		unset($json['redirect']);

		foreach ($json as $key => $value) {

			if($request->hasFile($key)) {

				$size = $request->file($key)->getSize();

				if(config('formman.tiers.' . $user->tier . '.can_use_files') || $size > config('formman.max_file_size')) {

					$url = $request->photo->store('images', 's3');

					$json['$key'] = $url;

				} else {

					unset($json['key']);

				}

			}

		}

		return $json;

	}

	private function isSpam($request)
	{

		return $request->has('important_checkbox');

	}

}