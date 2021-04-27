<?php

namespace App\Exceptions\Http;

class Http400Exception extends HttpException implements HttpCode
{
	protected $code = 400;
	protected $message = '400 Bad Request';
}
