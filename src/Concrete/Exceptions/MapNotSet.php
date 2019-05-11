<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Repo\Concrete\Exceptions;

/**
 * Description of MapNotSet
 *
 * @author d.lanec
 */
class MapNotSet extends Mapper {
	
	protected $column;
			
	function __construct($column) {
		$this->column = $column;
		parent::__construct(sprintf('No such field "%s"', $column));
	}
	
	function getColumn() {
		return $this->column;
	}
}
