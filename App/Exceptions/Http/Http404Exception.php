<?php

namespace App\Exceptions\Http;

class Http404Exception extends HttpException implements HttpCode
{
	protected $message = '404 Not Found';
	protected $code = 404;
}
