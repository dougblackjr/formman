<?php

namespace App\Services\Integrations;

use App\Comment;
use App\Item;
use App\Interfaces\IntegrationInterface;
use App\Services\Integrations\BaseIntegration;
use League\HTMLToMarkdown\HtmlConverter;
use Stevenmaguire\Services\Trello\Client as TrelloClient;
use Storage;

class TrelloIntegration extends BaseIntegration implements IntegrationInterface {

	public function authorize($params = [], $reauthorize = false)
	{

		if(isset($this->settings['token']) && !$reauthorize) return true;

		$this->connection = new TrelloClient([
			'key'			=> config('integration.trello.key'),
			'secret'		=> config('integration.trello.secret'),
		]);

		$reauth = $reauthorize ? 'y' : 'n';

		$config = [
			'expiration'		=> 'never',
			'name'				=> 'Punchlist',
			'scope'				=> 'read,write',
			'allowed_origins'	=> config('integration.integration_url'),
			'callbackUrl'		=> config('integration.integration_url') . '/integration/auth/' . $this->integration->id . '?reauth=' . $reauth,
			'return_url'		=> config('integration.integration_url') . '/integration/auth/' . $this->integration->id . '?reauth=' . $reauth,
			'callback_method'	=> 'fragment',
			'response_type'		=> 'token',
		];

		$this->connection->addConfig($config);

		$authorizationUrl = $this->connection->getAuthorizationUrl();

		return $authorizationUrl;

	}

	public function authorizeCallback($data = [])
	{

		$this->connection = new TrelloClient([
			'key'			=> config('integration.trello.key'),
			'secret'		=> config('integration.trello.secret'),
		]);

		$config = [
			'expiration'		=> 'never',
			'name'				=> 'Punchlist',
			'scope'				=> 'read,write',
			'allowed_origins'	=> config('integration.integration_url'),
			'callbackUrl'		=> config('integration.integration_url') . '/integration/auth/' . $this->integration->id,
			'return_url'		=> config('integration.integration_url') . '/integration/auth/' . $this->integration->id,
			'callback_method'	=> 'fragment',
			'response_type'		=> 'token',
		];

		$this->connection->addConfig($config);

		$token = $data['oauth_token'];
		$verifier = $data['oauth_verifier'];

		if( ! $token || ! $verifier) {
			return false;
		}

		$credentials = $this->connection->getAccessToken($token, $verifier);

		$accessToken = $credentials->getIdentifier();

		$tokenSecret = $credentials->getSecret();

		// Get Trello member
		$this->connection->addConfig('token', $accessToken);
		$trelloUser = $this->connection->getCurrentUser();

		$piData = $this->integration->data;

		$piData['token'] = $accessToken;
		$piData['token_secret'] = $tokenSecret;
		$piData['member'] = $trelloUser->id;

		$this->integration->data = $piData;

		$this->integration->save();

		return true;

	}

	public static function displayData($data)
	{

		return [
			'boardName' 	=> $data['boardName'],
			'listName'		=> $data['listName'],
			'display_name'	=> $data['boardName'],
		];

	}

	public function settingsData()
	{

		// Get base settings
		$base = parent::settingsData();

		// Add any additional
		$additional = [
			'member'	=> '',
			'board'		=> '',
			'list'		=> '',
		];

		return array_merge(
			$base,
			$additional
		);

	}
	
	public function createItem(Item $item)
	{

		$item->load('files', 'project', 'comments', 'itemMeta');

		$this->connection = new TrelloClient([
			'key'			=> config('integration.trello.key'),
			'token'			=> $this->settings['token'],
		]);

		try {

			$attributes = [
				'name'			=> strip_tags(nl2br('PL#' . $item->sub_id . ': ' . $item->body), '<br>'),
				'desc'			=> $this->convertToMarkdown(($item->video ? '[Video Feedback] ' : '') . $item->body)
									. "\n\n" . '------------------------' . "\n\n"
									. 'Browser: ' . ($item->itemMeta ? $item->itemMeta->browser : '') . ' ' . ($item->itemMeta ? $item->itemMeta->browser_version : '') . "\n\n"
									. 'Resolution: ' . ($item->itemMeta->screen_width ?? 'n/a') . (isset($item->itemMeta->screen_width) ? 'x' : '') . ($item->itemMeta->screen_height ?? 'n/a') . "\n\n"
									. 'Breakpoint: ' . ((isset($item->itemMeta->breakpoint) && $item->itemMeta->breakpoint && $item->itemMeta->breakpoint != '') ? $item->itemMeta->breakpoint : 'desktop')
									. "\n\n{$item->files->count()} File(s) Attached"
									. "\n\nSee more here: " . config('app.url') . '/share/' . $this->integration->data['share'] . '/item/' . $item->sub_id . '/details',
				'idList'		=> $this->settings['list'],
				// 'urlSource'		=> $this->getScreenshot($item->itemMeta->screenshot),
			];

			$this->output = $this->connection->addCard($attributes);

			// We'll set the item ID => Trello Card ID for safekeeping
			
			$integrationData = $this->integration['data'];

			if(! isset($integrationData['itemData'])) $integrationData['itemData'] = [];
			$integrationData['itemData'][$item->id] = $this->output->id;

			$this->integration->data = $integrationData;

			$this->integration->save();

		} catch (Stevenmaguire\Services\Trello\Exceptions\Exception $e) {

			$this->error = [
				'code' => $e->getCode(),
				'reason' => $e->getMessage(),
				'error' => $e->getPrevious(),
				// 'body' => $e->getResponseBody(),
			];

			return $this->error();

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

	public function addScreenshotToItem(Item $item)
	{

		$item->load('itemMeta');

		$this->connection = new TrelloClient([
			'key'			=> config('integration.trello.key'),
			'token'			=> $this->settings['token'],
		]);

		$integrationData = $this->integration['data'];

		// If we don't have an item number, we'll skip it
		if( ! isset($integrationData['itemData'][$item->id]) ) {
			return true;
		}

		$cardId = $integrationData['itemData'][$item->id];

		try {

			if($item->itemMeta && $item->itemMeta->screenshot) {

				$file = $this->getScreenshotFromFilestack($item->itemMeta->screenshot, true, true);

				$attributes = [
				    'name'		=> 'screenshot.png',
				    'file'		=> fopen($file, 'r'),
				    'mimeType'	=> 'image/png',
				    // 'url'		=> null,
				];

				// Storage::delete(rtrim(storage_path(), '/') . '/' . $file);

				$this->output = $this->connection->addCardAttachment($cardId, $attributes);
			}

		} catch (Stevenmaguire\Services\Trello\Exceptions\Exception $e) {

			$this->error = [
				'code' => $e->getCode(),
				'reason' => $e->getMessage(),
				'error' => $e->getPrevious(),
				'body' => $e->getResponseBody(),
			];

			return $this->error();
		}

		return true;

	}
	
	public function updateItem(Item $item)
	{

		$item->load('files', 'project', 'comments');

		$this->connection = new TrelloClient([
			'key'			=> config('integration.trello.key'),
			'token'			=> $this->settings['token'],
		]);

		$integrationData = $this->integration['data'];

		// If we don't have an item number, we should be creating this instead
		if( ! isset($integrationData['itemData'][$item->id]) ) {
			return $this->createItem($item);
		}

		$cardId = $integrationData['itemData'][$item->id];

		try {

			$attributes = [
				'name'			=> strip_tags(nl2br('PL#' . $item->sub_id . ': ' . $item->body), '<br>'),
				'desc'			=> $this->convertToMarkdown(($item->video ? '[Video Feedback] ' : '') . $item->body)
									. "\n\n" . '------------------------' . "\n\n"
									. 'Browser: ' . ($item->itemMeta ? $item->itemMeta->browser : '') . ' ' . ($item->itemMeta ? $item->itemMeta->browser_version : '') . "\n\n"
									. 'Resolution: ' . ($item->itemMeta->screen_width ?? 'n/a') . (isset($item->itemMeta->screen_width) ? 'x' : '') . ($item->itemMeta->screen_height ?? 'n/a') . "\n\n"
									. 'Breakpoint: ' . ((isset($item->itemMeta->breakpoint) && $item->itemMeta->breakpoint && $item->itemMeta->breakpoint != '') ? $item->itemMeta->breakpoint : 'desktop')
									. "\n\n{$item->files->count()} File(s) Attached"
									. "\n\nSee more here: " . config('app.url') . '/share/' . $this->integration->data['share'] . '/item/' . $item->sub_id . '/details',
				'id'			=> $cardId,
				// 'urlSource'		=> $this->getScreenshot($item->itemMeta->screenshot),
			];

			$this->output = $this->connection->updateCard($cardId, $attributes);

		} catch (Stevenmaguire\Services\Trello\Exceptions\Exception $e) {

			$this->error = [
				'code' => $e->getCode(),
				'reason' => $e->getMessage(),
				'error' => $e->getPrevious(),
				'body' => $e->getResponseBody(),
			];

			return $this->error();
		}

		return true;

	}

	public function createComment(Item $item, Comment $comment)
	{

		$item->load('files', 'project', 'comments');

		$this->connection = new TrelloClient([
			'key'			=> config('integration.trello.key'),
			'token'			=> $this->settings['token'],
		]);

		$integrationData = $this->integration['data'];

		$cardId = $integrationData['itemData'][$item->id];

		try {

			$attributes = [
				'text'			=> $this->convertToMarkdown($comment->comment),
				'id'			=> $cardId
			];

			$this->output = $this->connection->addCardActionComment($cardId, $attributes);

		} catch (Stevenmaguire\Services\Trello\Exceptions\Exception $e) {

			$this->error = [
				'code' => $e->getCode(),
				'reason' => $e->getMessage(),
				'error' => $e->getPrevious(),
				'body' => $e->getResponseBody(),
			];

			return $this->error();
		}

		return true;

	}
	
	public function completeItem(Item $item)
	{
		$this->connection = new TrelloClient([
			'key'			=> config('integration.trello.key'),
			'token'			=> $this->settings['token'],
		]);

		$integrationData = $this->integration['data'];

		$cardId = $integrationData['itemData'][$item->id];

		try {

			$attributes = [
				'closed'	=> true,
			];

			$this->output = $this->connection->updateCard($cardId, $attributes);

		} catch (Stevenmaguire\Services\Trello\Exceptions\Exception $e) {

			$this->error = [
				'code' => $e->getCode(),
				'reason' => $e->getMessage(),
				'error' => $e->getPrevious(),
				'body' => $e->getResponseBody(),
			];

			return $this->error();
		}

		return true;

	}

	public function getWorkspaces()
	{
		$this->connection = new TrelloClient([
			'key'			=> config('integration.trello.key'),
			'token'			=> $this->settings['token'],
		]);

		try {

			$this->output = $this->connection->getCurrentUserBoards();

		} catch (Stevenmaguire\Services\Trello\Exceptions\Exception $e) {

			$this->error = [
				'code' => $e->getCode(),
				'reason' => $e->getMessage(),
				'error' => $e->getPrevious(),
				'body' => $e->getResponseBody(),
			];

			return $this->error();
		}

		return true;
	}

	public function getBoards()
	{

		$this->connection = new TrelloClient([
			'key'			=> config('integration.trello.key'),
			'token'			=> $this->settings['token'],
		]);

		try {

			$this->output = $this->connection->getCurrentUserBoards();

		} catch (Stevenmaguire\Services\Trello\Exceptions\Exception $e) {

			$this->error = [
				'code' => $e->getCode(),
				'reason' => $e->getMessage(),
				'error' => $e->getPrevious(),
				'body' => $e->getResponseBody(),
			];

			return $this->error();
		}

		return true;

	}

	public function getLists($boardId)
	{

		$this->connection = new TrelloClient([
			'key'			=> config('integration.trello.key'),
			'token'			=> $this->settings['token'],
		]);

		try {

			$this->output = $this->connection->getBoardLists($boardId);

		} catch (Stevenmaguire\Services\Trello\Exceptions\Exception $e) {

			$this->error = [
				'code' => $e->getCode(),
				'reason' => $e->getMessage(),
				'error' => $e->getPrevious(),
				'body' => $e->getResponseBody(),
			];

			return $this->error();
		}

		return true;

	}

	public function getList($listId)
	{

		$this->connection = new TrelloClient([
			'key'			=> config('integration.trello.key'),
			'token'			=> $this->settings['token'],
		]);

		try {

			$this->output = $this->connection->getList($listId);

		} catch (Stevenmaguire\Services\Trello\Exceptions\Exception $e) {

			$this->error = [
				'code' => $e->getCode(),
				'reason' => $e->getMessage(),
				'error' => $e->getPrevious(),
				'body' => $e->getResponseBody(),
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

	private function getScreenshotLocal($item)
	{
		return Storage::disk('s3')->get($item->itemMeta->screenshot);
	}

}