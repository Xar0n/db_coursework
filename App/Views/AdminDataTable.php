<?php

namespace App\Views;

class AdminDataTable
{
	protected $rows;
	protected $columns;

	public function __construct(array $rows, array $columns)
	{
		$this->rows = $rows;
		$this->columns = $columns;
	}

	public function render(string $template)
	{
		$view = new View();
		$view->rows = $this->rows;
		$view->columns = $this->columns;
		$view->display($template);
	}
}