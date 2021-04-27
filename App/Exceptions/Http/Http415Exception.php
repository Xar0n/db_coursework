<?php

namespace App\Exceptions\Http;

class Http415Exception extends HttpException implements HttpCode
{
	protected $message = '415 Unsupported Media Type';
	protected $code = 415;
}
