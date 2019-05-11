<?php

namespace Repo\Concrete;

use Repo\EntityInterface;
use Repo\ExportableInterface;

/**
 * Description of AbstractEntity
 *
 * @author Dmitriy
 */
abstract class AbstractEntity implements EntityInterface, ExportableInterface {

	protected $id;

	/**
	 * @return int
	 */
	function getId() {

		return $this->id;
	}

	/**
	 * @param int $id
	 *
	 * @return $this
	 */
	function setId($id) {

		$this->id = $id;

		return $this;
	}

	/**
	 * Return an associative array containing all the properties in this object.
	 *
	 * @return array
	 */
	public function toArray():array {

		return get_object_vars($this);
	}

	public function tojson():string {

		return json_encode($this->toArray());
	}

}
