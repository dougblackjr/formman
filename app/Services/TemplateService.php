<?php

namespace App\Services;

use App\EmailResponse;
use App\Response;
use Str;

class TemplateService {

	public static function parse($string, Response $response)
	{
		$data = $response->data;
		foreach($data as $key => $val) {
			$count = 1;
			do {
				$stringKey = '{' . $key . '}';
				$count = substr_count($string, $stringKey);
				if($count > 0) {
					$string = Str::replaceFirst($stringKey, $val, $string);
				}
			} while($count > 0);
		}

		return $string;
	}

}