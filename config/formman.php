<?php

return [
	'use_limits'		=> env('FORMMAN_USE_LIMITS'),
	'contact_form_url'	=> env('FORMMAN_CONTACT_URL'),
	'max_file_size'		=> 2097152,
	'tiers'	=> [
		'free' => [
			'can_use_files'	=> false,
			'responses' => 50,
			'can_use_api' => false,
		],
		'paid' => [
			'can_use_files'	=> true,
			'responses' => 4567890, // Unlimited
			'can_use_api' => false,
		],
		'enterprise' => [
			'can_use_files'	=> true,
			'responses' => 4567890123123, // Really unlimited
			'can_use_api' => true,
		],
		'admin' => [
			'can_use_files'	=> true,
			'responses' => 4567890123123, // Really unlimited
			'can_use_api' => true,
		],
	],
];