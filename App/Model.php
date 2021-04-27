<?php

namespace App;

use App\Exceptions\Errors;
use App\Exceptions\Model\ItemNotFoundException;
use App\Exceptions\Http\Http400Exception;

/**
 * Class Model
 *
 * @package  App
 * @property $id
 */
abstract class Model
{
	/**
	 * @var integer
	 */
	public $id;
	protected static $table = null;

	/**
	 * @return array
	 * @static
	 * @access public
	 */
	public static function findAll()
	{
		$db = new DB();
		$sql = 'SELECT * FROM ' . static::$table;
		return $db->query($sql, [], static::class);
	}

	public static function findAllEach()
	{
		$db = new DB();
		$sql = 'SELECT * FROM ' . static::$table;
		return $db->queryEach($sql, [], static::class);
	}

	/**
	 * @param int $id
	 * @return object|bool
	 */
	public static function findById(int $id)
	{
		$db = new DB();
		$sql = 'SELECT * FROM ' . static::$table . ' WHERE id = :id';
		$result = $db->query($sql, [':id' => $id], static::class);
		if (empty($result)) {
			throw new ItemNotFoundException;
		}
		return $result[0];
	}

	/**
	 * @return bool
	 * @access protected
	 */
	protected function update(): bool
	{
		$fields = get_object_vars($this);
		$sets = [];
		$data = [];
		foreach ($fields as $name => $value) {
			$data[':' . $name] = $value;
			if ('id' == $name) {
				continue;
			}
			$sets[] = $name . '=:' . $name;
		}
		$sql = '
			UPDATE ' . static::$table . '
			SET ' . implode(', ', $sets) . '
			WHERE id=:id';
		$db = new DB();
		return $db->execute($sql, $data);
	}

	/**
	 * @return bool
	 * @access protected
	 */
	protected function insert(): bool
	{
		$fields = get_object_vars($this);
		$sets_fields = [];
		$data = [];
		foreach ($fields as $name => $value) {
			if ('id' == $name) {
				continue;
			}
			$data[':' . $name] = $value;
			$sets_fields[] = $name;
		}
		$sql = '
			INSERT ' . static::$table .
			'(' . implode(', ', $sets_fields) . ') 
			VALUES(' . implode(', ', array_keys($data)) . ')';
		$db = new DB();
		$result = $db->execute($sql, $data);
		if ($result) {
			$this->id = $db->getDbh()
				->lastInsertId();
		}
		return $result;
	}

	/**
	 * @access public
	 */
	public function save(): bool
	{
		$fields = get_object_vars($this);
		if (empty($fields['id'])) {
			return $this->insert();
		} else {
			return $this->update();
		}
	}

	/**
	 * @access public
	 * @return bool
	 */
	public function delete(): bool
	{
		$fields = get_object_vars($this);
		if (empty($fields['id'])) {
			return false;
		}
		$db = new DB();
		$sql = 'DELETE FROM ' . static::$table . ' WHERE id = :id';
		return $db->execute($sql, [':id' => $fields['id']]);
	}

	public function fill(array $data)
	{
		$errors = new Errors;
		foreach ($data as $key => $value) {
			if (property_exists($this, $key)) {
				$this->$key = $value;
			} else {
				$errors->add(new \OutOfBoundsException(
					'Свойство ' . $key . ' отсутствует в заполняемом объекте.'
				));
			}
		}
		if (!$errors->empty()) {
			throw $errors;
		}
	}
}
