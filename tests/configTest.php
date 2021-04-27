<?php
require __DIR__ . '/../autoload.php';
use App\Config;

$config = Config::getInstance();
echo $config->data['db']['host'];