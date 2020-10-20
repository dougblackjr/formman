<?php

namespace App\Services\Integrations;

use App\Comment;
use App\Exceptions\IntegrationException;
use App\Item;
use App\ProjectIntegration;
use App\Services\FilestackService;
use Illuminate\Support\Arr;
use Log;
use Storage;

abstract class BaseIntegration {

	public $connection;

	public $output;

	public $integration;

	public $authorizeUrl;

	public $project;

	public $settings;

	public $ready = false;

	public $success = false;

	public $error;

	public function __construct()
	{
		$this->fileService = new FilestackService(
			config('filestack.app_key'),
			config('filestack.app_secret')
		);
	}

	public function init(ProjectIntegration $integration)
	{

		$this->integration = $integration;

		$this->settings = $integration->data;

		$this->project = $integration->project;

	}

	public function settingsData()
	{

		return [
			'token'				=> '',
			'projectId'			=> '',
			'shouldCreate'		=> false,
			'shouldUpdate'		=> false,
			'shouldAddComments'	=> false,
			'shouldComplete'	=> false,
			'itemData'			=> [],
		];

	}

	public function output()
	{

		return collect($this->output);

	}

	public function error()
	{

		Log::error('INTEGRATION ERROR');
		Log::error($this->error);

		throw new IntegrationException($this->error);

	}

	public function getSetting($key)
	{

		return Arr::get($this->settings, $key);

	}

	public function getScreenshot($fileName)
	{

		return Storage::disk('s3')->url(sprintf('images/%s', $fileName));

	}

	public function getScreenshotFromFilestack($path, $download = false, $getPath = false)
	{

		$return = null;

		if($download) {
			$fileName = $path . '.png';
			Storage::disk('temp')->put($fileName, $this->fileService->getContent($path));
			$return = $getPath ? Storage::disk('temp')->path($fileName) : Storage::disk('temp')->get($fileName);
			if(!$getPath) Storage::disk('temp')->delete($fileName);
		} else {
			$return = $this->fileService->getUrl($path);
		}

		return $return;

	}

}