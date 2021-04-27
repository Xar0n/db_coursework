<?php

namespace App;

class Config
{
	public $data = array();
	private static $instance = null;
	protected const CONFIG = 'config.php';

	private function __construct()
	{
		$this->data = include __DIR__ . '/../' . self::CONFIG;
	}

	private function __clone()
	{
	}

	public static function getInstance()
	{
		if (static::$instance === null) {
			static::$instance = new static();
		}
		return static::$instance;
	}
}
