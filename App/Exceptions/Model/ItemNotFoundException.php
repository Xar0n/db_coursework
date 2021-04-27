<?php

namespace App\Exceptions\Model;

class ItemNotFoundException extends ModelException
{
	protected $message = 'Item not found';
}
