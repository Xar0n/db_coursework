<?php

namespace App\Models;

use App\Model;

/**
 * Class Author
 *
 * @package  App\Models
 * @category Model
 */
class Author extends Model
{
	/**
	 * @var string|null
	 * @static
	 * @access protected
	 */
	protected static $table = 'authors';
	/**
	 * @var string
	 * @access public
	 */
	public $name;
}
