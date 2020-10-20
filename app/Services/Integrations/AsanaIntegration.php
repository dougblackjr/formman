<?php

namespace App\Services\Integrations;

use App\Comment;
use App\Item;
use App\Interfaces\IntegrationInterface;
use App\Services\Integrations\BaseIntegration;
use Asana\Client as AsanaClient;
use League\HTMLToMarkdown\HtmlConverter;
use Storage;

class AsanaIntegration extends BaseIntegration implements IntegrationInterface {

	public function authorize($params = [], $reauthorize = false)
	{

		if(isset($this->settings['token']) && !$reauthorize) return true;

		$this->connection = AsanaClient::oauth([
			'client_id'		=> config('integration.asana.key'),
			'client_secret'	=> config('integration.asana.secret'),
			'redirect_uri'  => config('integration.oauth_callback_uri'),
		]);

		$reauth = $reauthorize ? 'y' : 'n';

		// We'll use this since we can't send a lot of data to Asana
		$state = "asana--{$this->project->id}--{$this->integration->id}--{$reauth}";

		$authorizationUrl = $this->connection->dispatcher->authorizationUrl($state);

		return $authorizationUrl;

	}

	public function authorizeCallback($data = [])
	{

		$this->connection = AsanaClient::oauth([
			'client_id'		=> config('integration.asana.key'),
			'client_secret'	=> config('integration.asana.secret'),
			'redirect_uri'  => config('integration.oauth_callback_uri'),
		]);

		$state = $data['state'];
		$code = $data['code'];

		$token = $this->connection->dispatcher->fetchToken($code);
		$refreshToken = $this->connection->dispatcher->refreshToken;

		if( ! $token ) {
			return false;
		}

		$user = $this->connection->users->getUser("me");

		$piData = $this->integration->data;

		$piData['token'] = $token;
		$piData['refresh_token'] = $refreshToken;
		$piData['member'] = $user->gid;

		$this->integration->data = $piData;

		$this->integration->save();

		return true;

	}

	public function reauthorize()
	{

		$token = $this->connection->dispatcher->refreshAccessToken();

		$refreshToken = $this->connection->dispatcher->refreshToken;

		if( ! $this->connection->dispatcher->authorized ) {
			$this->error = [
				'code' => $e->getCode(),
				'reason' => 'Please reauthenticate your integration',
				'error' => $e->getPrevious(),
			];

			return $this->error();
		}
		
		$piData = $this->integration->data;
		$piData['token'] = $token;
		$piData['refresh_token'] = $refreshToken;

		$this->integration->data = $piData;

		$this->integration->save();


		return $token;

	}

	public static function displayData($data)
	{

		return [
			'workspaceName'	=> $data['workspaceName'],
			'projectName' 	=> $data['projectName'],
			'display_name'	=> $data['workspaceName'],
		];

	}

	public function settingsData()
	{

		// Get base settings
		$base = parent::settingsData();

		// Add any additional
		$additional = [
			'workspace'	=> '',
			'project'	=> '',
		];

		return array_merge(
			$base,
			$additional
		);

	}
	
	public function createItem(Item $item)
	{

		$item->load('files', 'project', 'comments', 'itemMeta');

		// $this->connection = AsanaClient::accessToken($this->settings['token']);
		$this->connection = AsanaClient::oauth([
								'client_id'		=> config('integration.asana.key'),
								'client_secret'	=> config('integration.asana.secret'),
								'token'			=> $this->settings['token'],
								'access_token'	=> $this->settings['token'],
								'refresh_token'	=> $this->settings['refresh_token'] ?? null,
								'redirect_uri'  => config('integration.oauth_callback_uri'),
							]);

		$this->reauthorize();

		try {

			$attributes = [
				'name'			=> 'PL#' . $item->sub_id . ' ' . $this->parseTextForSending($item->body),
				'html_notes'	=> '<body>' . ($item->video ? '[Video Feedback] ' : '') . $this->parseTextForSending($item->body)
									. "\n\n" . '------------------------' . "\n\n"
									. 'Browser: ' . ($item->itemMeta ? $item->itemMeta->browser : '') . ' ' . ($item->itemMeta ? $item->itemMeta->browser_version : '') . "\n\n"
									. 'Resolution: ' . ($item->itemMeta ? $item->itemMeta->screen_width : '') . 'x' . ($item->itemMeta ? $item->itemMeta->screen_height : '') . "\n\n"
									. 'Breakpoint: ' . ((isset($item->itemMeta->breakpoint) && $item->itemMeta->breakpoint && $item->itemMeta->breakpoint != '') ? $item->itemMeta->breakpoint : 'desktop')
									. "\n\n{$item->files->count()} File(s) Attached"
									. "\n\nSee more here: "
									. config('app.url')
									. '/share/'
									. $this->integration->data['share']
									. '/item/'
									. $item->sub_id . '/details</body>',
				'projects'		=> [
					$this->integration['data']['project'],
				],
			];

			$this->output = $this->connection->tasks->createInWorkspace($this->integration['data']['workspace'], $attributes);

			// We'll set the item ID => Asana task ID for safekeeping
			$integrationData = $this->integration['data'];

			if(! isset($integrationData['itemData'])) $integrationData['itemData'] = [];
			$integrationData['itemData'][$item->id] = $this->output->gid;

			$this->integration->data = $integrationData;

			$this->integration->save();

		} catch (\Exception $e) {

			$this->error = [
				'code' => $e->getCode(),
				'reason' => 'ASANA Create: ' . $e->getMessage(),
				'error' => $e->getPrevious(),
			];

			return $this->error();

		}

		try {

			if($item->itemMeta && Storage::disk('s3')->exists($item->itemMeta->screenshot)) {
				$this->connection->attachments->createOnTask(
				    $this->output->gid,
				    $this->getScreenshotFile($item->itemMeta->screenshot),
				    "screenshot.png",
				    "image/png"
				);
			}

		} catch(\Exception $e) {

			$this->error = [
				'code' => $e->getCode(),
				'reason' => 'ASANA Screenshot: ' . $e->getMessage(),
				'error' => $e->getPrevious(),
			];

			return $this->error();

		}

		return true;

	}

	public function addScreenshotToItem(Item $item)
	{

		$item->load('itemMeta');

		$this->connection = AsanaClient::oauth([
								'client_id'		=> config('integration.asana.key'),
								'client_secret'	=> config('integration.asana.secret'),
								'token'			=> $this->settings['token'],
								'access_token'	=> $this->settings['token'],
								'refresh_token'	=> $this->settings['refresh_token'] ?? null,
								'redirect_uri'  => config('integration.oauth_callback_uri'),
							]);

		$this->reauthorize();

		$integrationData = $this->integration['data'];

		// If we don't have an item number, we'll skip it for now
		if( ! isset($integrationData['itemData'][$item->id]) ) {
			return true;
		}

		$cardId = $integrationData['itemData'][$item->id];

		try {

			if($item->itemMeta && $item->itemMeta->screenshot) {
				$this->connection->attachments->createOnTask(
				    $cardId,
				    $this->getScreenshotFromFilestack($item->itemMeta->screenshot, true),
				    "screenshot-{$item->id}.png",
				    "image/png"
				);
			}

		} catch(\Exception $e) {

			$this->error = [
				'code' => $e->getCode(),
				'reason' => 'ASANA Screenshot: ' . $e->getMessage(),
				'error' => $e->getPrevious(),
			];

			return $this->error();

		}

		return true;

	}
	
	public function updateItem(Item $item)
	{

		$item->load('files', 'project', 'comments');

		$this->connection = AsanaClient::oauth([
								'client_id'		=> config('integration.asana.key'),
								'client_secret'	=> config('integration.asana.secret'),
								'token'			=> $this->settings['token'],
								'access_token'	=> $this->settings['token'],
								'refresh_token'	=> $this->settings['refresh_token'] ?? null,
								'redirect_uri'  => config('integration.oauth_callback_uri'),
							]);

		$this->reauthorize();

		$integrationData = $this->integration['data'];

		// If we don't have an item number, we should be creating this instead
		if( ! isset($integrationData['itemData'][$item->id]) ) {
			return $this->createItem($item);
		}

		$cardId = $integrationData['itemData'][$item->id];

		try {

			$attributes = [
				'body'	=> [
					'name'			=> $this->parseTextForSending($item->body),
					'html_notes'	=> '<body>' . 'PL#' . $item->sub_id . ' ' . ($item->video ? '[Video Feedback] ' : '') . $this->parseTextForSending($item->body)
										. "\n\n" . '------------------------' . "\n\n"
										. 'Browser: ' . ($item->itemMeta ? $item->itemMeta->browser : '') . ' ' . ($item->itemMeta ? $item->itemMeta->browser_version : '') . "\n\n"
										. '<p>Resolution: ' . ($item->itemMeta->screen_width ?? 'n/a') . (isset($item->itemMeta->screen_width) ? 'x' : '') . ($item->itemMeta->screen_height ?? 'n/a') . "</p>"
										. 'Breakpoint: ' . ((isset($item->itemMeta->breakpoint) && $item->itemMeta->breakpoint && $item->itemMeta->breakpoint != '') ? $item->itemMeta->breakpoint : 'desktop')
										. "\n\n{$item->files->count()} File(s) Attached"
										. "\n\nSee more here: "
										. config('app.url')
										. '/share/'
										. $this->integration->data['share']
										. '/item/'
										. $item->sub_id . '/details</body>',
				]
			];

			$this->output = $this->connection->tasks->update($cardId, $attributes);

		} catch (\Exception $e) {

			$this->error = [
				'code' => $e->getCode(),
				'reason' => $e->getMessage(),
				'error' => $e->getPrevious(),
				// 'body' => $e->getResponseBody(),
			];

			return $this->error();
		}

		return true;

	}

	public function createComment(Item $item, Comment $comment)
	{

		// Asana API doesn't allow this. Ugh
		return true;

	}
	
	public function completeItem(Item $item)
	{
		
		$item->load('files', 'project', 'comments');

		$this->connection = AsanaClient::oauth([
								'client_id'		=> config('integration.asana.key'),
								'client_secret'	=> config('integration.asana.secret'),
								'token'			=> $this->settings['token'],
								'access_token'	=> $this->settings['token'],
								'refresh_token'	=> $this->settings['refresh_token'] ?? null,
								'redirect_uri'  => config('integration.oauth_callback_uri'),
							]);

		$this->reauthorize();

		$integrationData = $this->integration['data'];

		$cardId = $integrationData['itemData'][$item->id];

		try {

			$attributes = [
				'completed'	=> true,
			];

			$this->output = $this->connection->tasks->update($cardId, $attributes);

		} catch (\Exception $e) {

			$this->error = [
				'code' => $e->getCode(),
				'reason' => $e->getMessage(),
				'error' => $e->getPrevious(),
				// 'body' => $e->getResponseBody(),
			];

			return $this->error();
		}

		return true;

	}

	public function getWorkspaces()
	{

		$this->connection = AsanaClient::oauth([
			'client_id'		=> config('integration.asana.key'),
			'client_secret'	=> config('integration.asana.secret'),
			'token'			=> $this->settings['token'],
			'access_token'	=> $this->settings['token'],
			'refresh_token'	=> $this->settings['refresh_token'] ?? null,
			'redirect_uri'  => config('integration.oauth_callback_uri'),
		]);

		$this->reauthorize();

		try {

			$this->output = $this->connection->workspaces->findAll();

		} catch (\Exception $e) {

			$this->error = [
				'code' => $e->getCode(),
				'reason' => $e->getMessage(),
				'error' => $e->getPrevious(),
				// 'body' => $e->getResponseBody(),
			];

			return $this->error();
		}

		return true;

	}

	public function getProjectByWorkspace($params)
	{

		$this->connection = AsanaClient::oauth([
			'client_id'		=> config('integration.asana.key'),
			'client_secret'	=> config('integration.asana.secret'),
			'token'			=> $this->settings['token'],
			'access_token'	=> $this->settings['token'],
			'refresh_token'	=> $this->settings['refresh_token'] ?? null,
			'redirect_uri'  => config('integration.oauth_callback_uri'),
		]);

		$this->reauthorize();

		try {

			$this->output = $this->connection->projects->findByWorkspace($params, ['archived' => false]);

		} catch (\Exception $e) {

			$this->error = [
				'code' => $e->getCode(),
				'reason' => $e->getMessage(),
				'error' => $e->getPrevious(),
				// 'body' => $e->getResponseBody(),
			];

			return $this->error();
		}

		return true;

	}

	private function convertToMarkdown($text)
	{

		$converter = new HtmlConverter;

		return $converter->convert($text);

	}

	private function parseTextForSending($text)
	{

		$text = str_replace('<p>', '', $text);
		$text = str_replace('</p>', "\n", $text);

		return strip_tags($text);

	}

	private function getScreenshotFile($fileName)
	{

		return Storage::disk('s3')->get(sprintf('images/%s', $fileName));

	}

}