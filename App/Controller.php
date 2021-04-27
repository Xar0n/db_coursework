<?php

namespace App;

use App\Exceptions\Controller\ActionNotFound;
use App\Exceptions\Http\Http403Exception;
use App\Exceptions\Http\Http404Exception;
use App\Exceptions\Model\ItemNotFoundException;
use App\Views\View;

abstract class Controller
{
	protected $view;

	public function __construct()
	{
		$this->view = new View();
	}

	public function action(string $name)
	{
		$method = 'action' . ucfirst($name);
		if ($this->access()) {
			$this->$method();
		} else {
			throw new Http403Exception;
		}
	}

	public function access()
	{
		return true;
	}
}
