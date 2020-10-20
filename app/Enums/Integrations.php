<?php

namespace App\Enums;

use App\Services\Integrations\AsanaIntegration;
use App\Services\Integrations\JiraIntegration;
use App\Services\Integrations\TrelloIntegration;
use App\Traits\Enum;

class Integrations
{

	use Enum;

	public const TRELLO = [
		'title'			=> 'Trello',
		'short_name'	=> 'trello',
		'byline'		=> 'Automatically or manually move items directly to Trello',
		'logo_image'	=> 'trello-logo-blue.png',
		'class'			=> TrelloIntegration::class,
		'fa_class'		=> 'fab fa-trello',
		'oauth'			=> true,
	];

	public const ASANA = [
		'title'			=> 'Asana',
		'short_name'	=> 'asana',
		'byline'		=> 'Automatically or manually move items directly to Asana',
		'logo_image'	=> 'asana-horizontal.png',
		'class'			=> AsanaIntegration::class,
		'fa_class'		=> 'fas fa-cogs',
		'oauth'			=> true,
	];

	public const JIRA = [
		'title'			=> 'Jira',
		'short_name'	=> 'jira',
		'byline'		=> 'Automatically or manually move items directly to Jira',
		'logo_image'	=> 'jira-logo.png',
		'class'			=> JiraIntegration::class,
		'fa_class'		=> 'fab fa-jira',
		'oauth'			=> false,
	];

}