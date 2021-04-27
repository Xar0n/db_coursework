<?php

namespace App\Exceptions\Http;

class Http403Exception extends HttpException implements HttpCode
{
	protected $message = '403 Forbidden';
	protected $code = 403;
}
