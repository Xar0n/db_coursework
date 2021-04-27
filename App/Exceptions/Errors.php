<?php

namespace App\Exceptions;

use App\Traits\Iterator;

class Errors extends \Exception implements \Iterator
{
	use Iterator;
	protected $data = array();

	public function add(\Throwable $e)
	{
		$this->data[] = $e;
	}

	public function getAll()
	{
		return $this->data;
	}

	public function empty(): bool
	{
		return empty($this->data);
	}
}
