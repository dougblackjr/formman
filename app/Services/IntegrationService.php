<?php

namespace App\Services;

use App\Form;
use App\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class IntegrationService
{

	public $integration_id;
	public $method;
	public $form;
	public $response;

	public function __construct(Form $form, Response $response)
	{
		$this->form = $form;
		$this->response = $response;
	}

	public function check($request, $next, $params = [])
	{
		foreach ($this->project->integrations as $integration) {
			$iData = $integration->data;
			if(isset($iData['itemData'][$this->item->id])) {
				$this->integration_id = $integration->id;
				$this->method = $next;
				$this->{$next}($request);
			}
		}
	}

	public function get($request)
	{

		$integrationData = $this->form->integrations
									->where('active', true)
									->map(function($i) {

										$iData = $i->data;

										$integration = constant('App\Enums\Integrations::' . $iData['type']);

										$initialData = [
											'integration_id'	=> $i->id,
											'form_id'			=> $this->form->id,
											'integration'		=> $integration['title'],
										];

										$integrationDisplayData = $integration['class']::displayData($iData);

										return array_merge(
											$initialData,
											$integrationDisplayData
										);
									});

		return [
			'success'	=> true,
			'data'		=> $integrationData,
		];

	}

	public function createRespone($request)
	{
		$formIntegration = FormIntegration::find($request->integration_id ?? $this->integration_id);

		if(!$formIntegration) {
			return [
				'success'	=> false,
				'data'		=> 'Integration not found',
			];
		}

		$iData = $formIntegration->data;
		$integrationEnum = constant( 'App\Enums\Integrations::' . $iData['type'] );
		$integration = new $integrationEnum['class'];
		$integration->init($formIntegration);
		$result = $integration->{$request->method ?? $this->method}($this->item);

		if($result !== true) {
			return [
				'success'	=> false,
				'data'		=> $result,
			];
		}

		return [
			'success'	=> true,
			'data'	=> $integration->output(),
		];

	}

}