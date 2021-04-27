<?php

namespace App\Views;

class Twig
{
	protected $twig;

	public function __construct()
	{
		$loader = new \Twig_Loader_Filesystem(__DIR__ . '/../Templates');
		$this->twig = new \Twig_Environment($loader);
	}

	public function display(string $template, array $params = [])
	{
		echo $this->twig->render($template, $params);
	}
}
