<?php

namespace App\Services;

use App\Form;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Type;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\Style\Color;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ExportService extends BaseService {

	protected $form;

	protected $responses;

	protected $extra_headers;

	public $headers;

	public $data;

	public $file_name;

	public function __construct(Form $form)
	{

		$this->form = $form;

		$this->responses = $form->responses;

		$this->createHeaders();

		$this->parseItems($form->responses);

		$this->file_name = Str::slug($form->name) . '-' . now()->format('Y-m-d');

	}

	public function toCsv()
	{

		if(empty($this->data)) return null;

		$writer = $writer = WriterEntityFactory::createCSVWriter();

		$writer->openToBrowser($this->file_name . '.csv');

		$headerRow = WriterEntityFactory::createRow($this->headers);

		$writer->addRow($headerRow); // add header

		$writer->addRows($this->data); // add multiple rows at a time

		$writer->close();

	}

	public function toExcel()
	{

		$writer = WriterEntityFactory::createXLSXWriter();

		$writer->openToBrowser($this->file_name . '.xlsx');

		$style = (new StyleBuilder())
		   ->setFontBold()
		   ->setFontSize(15)
		   ->setFontColor(Color::WHITE)
		   ->setShouldWrapText()
		   ->setBackgroundColor(Color::BLACK)
		   ->build();

		$writer->addRowWithStyle(WriterEntityFactory::createRow($this->headers), $style); // add header

		$writer->addRows($this->data); // add multiple rows at a time

		$writer->close();

	}

	private function createHeaders()
	{

		$headers = [
		    WriterEntityFactory::createCell('ip'),
		    WriterEntityFactory::createCell('date'),
		    WriterEntityFactory::createCell('status'),
		];

		$extra_headers = [];

		foreach ($this->responses as $response) {

			foreach ($response->data as $key => $value) {
				if(!in_array($key, $headers)) {
					$headers[] = WriterEntityFactory::createCell($key);
					$extra_headers[] = $key;
				}
			}
		}

		$this->headers = $headers;

		$this->extra_headers = $extra_headers;

	}

	private function parseItems($responses)
	{

		foreach ($responses as $item) {
			$this->data[] = $this->parseItem($item);
		}

	}

	private function parseItem($item)
	{

		$parsed = [
			WriterEntityFactory::createCell($item->ip_address),
			WriterEntityFactory::createCell($item->created_at->format('Y-m-d H:i:s')),
			WriterEntityFactory::createCell($this->parseStatus($item)),
		];

		$data = $item->data;

		foreach ($this->extra_headers as $h) {
			$parsed[$h] = WriterEntityFactory::createCell((isset($data[$h]) ? $data[$h] : ''));
		}

		return WriterEntityFactory::createRow($parsed);

	}

	private function parseStatus($item)
	{

		if($item->is_spam) {
			return 'spam';
		}

		return $item->is_active ? 'active' : 'archived';

	}

}