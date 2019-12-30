<?php

namespace App\Services;

use Auth;
use App\Response;

class FormmanService extends BaseService {

	public static function limit()
	{

		$user = Auth::user();

		return config("formman.tiers.{$user->tier}.responses");

	}

	public static function useLimits()
	{

		return config('formman.use_limits') ? true : false;

	}

	public static function hitLimit()
	{

		if(!self::useLimits()) return false;

		$user = Auth::user();

		$responseCount = Response::whereHas('form', function($query) use ($user) {
										$query->where('user_id', $user->id);
									})
									->InThisMonth()
									->withTrashed()
									->count();

		return $responseCount > config("formman.tiers.{$user->tier}.responses");

	}

}