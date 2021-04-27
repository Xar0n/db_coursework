<?php

namespace App\Traits;

trait Iterator
{

	protected $data = [];

	public function current()
	{
		return current($this->data);
	}

	public function next()
	{
		return next($this->data);
	}

	public function key()
	{
		return key($this->data);
	}

	public function valid()
	{
		return null !== key($this->data);
	}

	public function rewind()
	{
		return reset($this->data);
	}
}
