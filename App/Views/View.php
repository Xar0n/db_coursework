<?php

namespace App\Views;

use App\Traits\Magic;
use App\Traits\Iterator;

class View implements
	\Countable,
	\Iterator
{
	use Magic,
		Iterator;

	protected $data = [];

	public function render($template)
	{
		ob_start();
		foreach ($this->data as $key => $value) {
			$$key = $value;
		}
		include $template;
		$contents = ob_get_contents();
		ob_end_clean();
		return $contents;
	}

	public function display($template)
	{
		echo $this->render($template);
	}

	public function count()
	{
		return count($this->data);
	}
}
