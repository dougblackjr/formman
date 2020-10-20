<?php

namespace App\Services\Integrations;

use App\Comment;
use App\Item;
use App\Interfaces\IntegrationInterface;
use App\Services\Integrations\BaseIntegration;
use Illuminate\Support\Str;
use JiraRestApi\Configuration\ArrayConfiguration;
use JiraRestApi\Issue\Comment as JiraComment;
use JiraRestApi\Issue\IssueField;
use JiraRestApi\Issue\IssueService;
use JiraRestApi\Issue\Transition;
use JiraRestApi\JiraException;
use JiraRestApi\Project\ProjectService;
use JiraRestApi\User\UserService;
use League\HTMLToMarkdown\HtmlConverter;
use Log;
use Storage;

class JiraIntegration extends BaseIntegration implements IntegrationInterface {

	public function authorize($params = [], $reauthorize = false)
	{

		return true;

	}

	public function authorizeCallback($data = [])
	{

		return true;

	}

	public static function displayData($data)
	{

		return [
			'projectName' 	=> $data['projectName'],
			'display_name'	=> $data['projectName'],
		];

	}

	public function settingsData()
	{

		// Get base settings
		$base = parent::settingsData();

		// Add any additional
		$additional = [
			'should_notify'	=> false,
			'host'			=> '',
			'accountId'		=> '',
			'username'		=> '',
			'password'		=> '',
			'project'		=> '',
			'projectName'	=> '',
			'issue'			=> '',
		];

		return array_merge(
			$base,
			$additional
		);

	}
	
	public function createItem(Item $item)
	{

		$item->load('files', 'project', 'comments', 'itemMeta');

		$config = new ArrayConfiguration(
			[
				'jiraHost'		=> $this->settings['host'] ?? '',
				'jiraUser'		=> $this->settings['username'] ?? '',
				'jiraPassword'	=> $this->settings['password'] ?? '',
			]
		);

		try {

			$this->connection = new IssueService($config);

			$issueField = new IssueField();

			$issueField->setSummary(strip_tags(nl2br('PL#' . $item->sub_id . ': ' . $item->body), '<br>'))
						->setIssueType("Task")
						->setDescription(
							$this->convertToMarkdown(($item->video ? '[Video Feedback] ' : '') . $item->body)
							. "\n\n" . '------------------------' . "\n\n"
							. 'Browser: ' . ($item->itemMeta ? $item->itemMeta->browser : '') . ' ' . ($item->itemMeta ? $item->itemMeta->browser_version : '') . "\n\n"
							. 'Resolution: ' . ($item->itemMeta->screen_width ?? 'n/a') . (isset($item->itemMeta->screen_width) ? 'x' : '') . ($item->itemMeta->screen_height ?? 'n/a') . "\n\n"
							. 'Breakpoint: ' . ((isset($item->itemMeta->breakpoint) && $item->itemMeta->breakpoint && $item->itemMeta->breakpoint != '') ? $item->itemMeta->breakpoint : 'desktop')
							. "\n\n{$item->files->count()} File(s) Attached"
							. "\n\nSee more here: "
							. config('app.url')
							. '/share/'
							. $this->integration->data['share']
							. '/item/'
							. $item->sub_id
							. '/details'
						)
						->setProjectId($this->settings['project']);

			$this->output = $this->connection->create($issueField);

			$issueKey = $this->output->id;

			$fileName = $this->getScreenshotLocal($item->itemMeta->screenshot);

			if(isset($item->itemMeta->screenshot) && $fileName) {
				$this->connection->addAttachments($issueKey, 
					[
						$fileName
					]
				);
			}

			$integrationData = $this->integration['data'];

			if(! isset($integrationData['itemData'])) $integrationData['itemData'] = [];
			$integrationData['itemData'][$item->id] = $issueKey;

			$this->integration->data = $integrationData;

			$this->integration->save();

		} catch (JiraException $e) {

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

		$config = new ArrayConfiguration(
				[
					'jiraHost'		=> $this->settings['host'] ?? '',
					'jiraUser'		=> $this->settings['username'] ?? '',
					'jiraPassword'	=> $this->settings['password'] ?? '',
			]
		);

		$integrationData = $this->integration['data'];

		$issueKey = $integrationData['itemData'][$item->id] ?? null;

		if(!$issueKey) return true;
		
		try {

			$this->connection = new IssueService($config);


			$fileName = $this->getScreenshotFromFilestack($item->itemMeta->screenshot, true, true);

			if(isset($item->itemMeta->screenshot) && $fileName) {
				$this->connection->addAttachments($issueKey, 
					[
						$fileName
					]
				);
			}

			$integrationData = $this->integration['data'];

			if(! isset($integrationData['itemData'])) $integrationData['itemData'] = [];
			$integrationData['itemData'][$item->id] = $issueKey;

			$this->integration->data = $integrationData;

			$this->integration->save();

		} catch (JiraException $e) {

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
	
	public function updateItem(Item $item)
	{

		$item->load('files', 'project', 'comments');

		$integrationData = $this->integration['data'];

		$config = new ArrayConfiguration(
			[
				'jiraHost'		=> $this->settings['host'] ?? '',
				'jiraUser'		=> $this->settings['username'] ?? '',
				'jiraPassword'	=> $this->settings['password'] ?? '',
			]
		);

		$issueKey = $integrationData['itemData'][$item->id];

		$editParams = [
			'notifyUsers'	=> $this->settings['should_notify'] ?? false,
		];

		try {

			$this->connection = new IssueService($config);

			$issueField = new IssueField();

			$issueField->setSummary(strip_tags(nl2br('PL#' . $item->sub_id . ': ' . $item->body), '<br>'))
						->setIssueType("Task")
						->setDescription(
							$this->convertToMarkdown(($item->video ? '[Video Feedback] ' : '') . $item->body)
							. "\n\n" . '------------------------' . "\n\n"
							. 'Browser: ' . ($item->itemMeta ? $item->itemMeta->browser : '') . ' ' . ($item->itemMeta ? $item->itemMeta->browser_version : '') . "\n\n"
							. 'Resolution: ' . ($item->itemMeta->screen_width ?? 'n/a') . (isset($item->itemMeta->screen_width) ? 'x' : '') . ($item->itemMeta->screen_height ?? 'n/a') . "\n\n"
							. 'Breakpoint: ' . ((isset($item->itemMeta->breakpoint) && $item->itemMeta->breakpoint && $item->itemMeta->breakpoint != '') ? $item->itemMeta->breakpoint : 'desktop')
							. "\n\n{$item->files->count()} File(s) Attached"
							. "\n\nSee more here: "
							. config('app.url')
							. '/share/'
							. $this->integration->data['share']
							. '/item/'
							. $item->sub_id
							. '/details'
						)
						->setProjectId($this->settings['project']);

			$this->output = $this->connection->update($issueKey, $issueField, $editParams);

		} catch (JiraException $e) {

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

		$config = new ArrayConfiguration(
				[
					'jiraHost'		=> $this->settings['host'] ?? '',
					'jiraUser'		=> $this->settings['username'] ?? '',
					'jiraPassword'	=> $this->settings['password'] ?? '',
			]
		);

		$issueKey = $integrationData['itemData'][$item->id];

		$integrationData = $this->integration['data'];

		try {

			$comment = new JiraComment();

			$comment->setBody($this->convertToMarkdown($comment->comment));

			$this->connection = new IssueService($config);

			$this->output = $this->connection->addComment($issueKey, $comment);

		} catch (JiraException $e) {

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
		$item->load('files', 'project', 'comments');

		$config = new ArrayConfiguration(
				[
					'jiraHost'		=> $this->settings['host'] ?? '',
					'jiraUser'		=> $this->settings['username'] ?? '',
					'jiraPassword'	=> $this->settings['password'] ?? '',
			]
		);

		$integrationData = $this->integration['data'];

		$issueKey = $integrationData['itemData'][$item->id];

		try {

			$transition = new Transition;

			$transition->setTransitionName('Resolved');

			$this->connection = new IssueService($config);

			$this->output = $this->connection->transition($issueKey, $transition);

		} catch (JiraException $e) {

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
		$config = new ArrayConfiguration(
			[
				'jiraHost'		=> $this->settings['host'] ?? $params['host'],
				'jiraUser'		=> $this->settings['username'] ?? $params['username'],
				'jiraPassword'	=> $this->settings['password'] ?? $params['password'],
				'jiraLogLevel'	=> 'DEBUG',
				'jiraLogFile'	=> storage_path('logs/jira-rest-client.log'),
			]
		);

		try {

			$this->connection = new ProjectService($config);

			$this->output = $this->connection->getAllProjects();

		} catch (JiraException $e) {

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

	public function getProjects($params)
	{

		$config = new ArrayConfiguration(
			[
				'jiraHost'		=> $this->settings['host'] ?? $params['host'],
				'jiraUser'		=> $this->settings['username'] ?? $params['username'],
				'jiraPassword'	=> $this->settings['password'] ?? $params['password'],
				'jiraLogLevel'	=> 'DEBUG',
				'jiraLogFile'	=> storage_path('logs/jira-rest-client.log'),
			]
		);

		try {

			$this->connection = new ProjectService($config);

			$this->output = $this->connection->getAllProjects();

		} catch (JiraException $e) {

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

	public function checkAuth($params)
	{

		$config = new ArrayConfiguration(
			[
				'jiraHost'		=> $this->settings['host'] ?? $params['host'],
				'jiraUser'		=> $this->settings['username'] ?? $params['username'],
				'jiraPassword'	=> $this->settings['password'] ?? $params['password'],
			]
		);

		try {

			$this->connection = new UserService($config);

			$this->output = $this->connection->getMyself();

		} catch (JiraException | \ErrorException | \Exception $e) {

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

	private function getScreenshotLocal($name)
	{

		$fileName = Str::random() . '.png';

		try {

			$s3file = Storage::disk('s3')->get(sprintf('images/%s', $fileName));

		} catch (\Illuminate\Contracts\Filesystem\FileNotFoundException $e) {

			return false;

		}

		$file = Storage::disk('local')->put($fileName, $s3file);

		$url = storage_path('app') . '/' . $fileName;

		return $url;

	}

}