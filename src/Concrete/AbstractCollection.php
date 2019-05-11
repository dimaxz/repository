<?php

namespace Repo\Concrete;

use Repo\CollectionInterface;
use Repo\Concrete\Exceptions;

/**
 * Абстрактная коллекция для Enitities
 *
 * @author d.lanec
 */
class AbstractCollection implements CollectionInterface {

	protected $_entities = array();

	protected $_entityClass;
	
	protected $lastKey;

	/**
	 * @var int|null
	 */
	protected $foundRows;

	/**
	 * Constructor
	 */
	public function __construct(array $entities = array()) {
		if (!empty($entities)) {
			foreach($entities as $entity){
				$this->offsetSet($entity);
			}
		}
		$this->rewind();
	}

	/**
	 * @return int|null
	 */
	public function getFoundRows(): ?int {

		return $this->foundRows;
	}

	/**
	 * @param int|null $foundRows
	 *
	 * @return AbstractCollection
	 */
	public function setFoundRows(?int $foundRows): AbstractCollection {

		$this->foundRows = $foundRows;

		return $this;
	}
	

	/**
	 * Get the entities stored in the collection
	 */
	public function getEntities() {
		return $this->_entities;
	}

	/**
	 * Clear the collection
	 */
	public function clear() {
		$this->_entities = array();
	}

	/**
	 * Reset the collection (implementation required by Iterator Interface)
	 * @deprecated 
	 * @see  AbstractCollection::reset()
	 */
	public function rewind() {
		reset($this->_entities);
		return $this;
	}

	/**
	 * Get the current entity in the collection (implementation required by Iterator Interface)
	 */
	public function current() {
		return current($this->_entities);
	}

	/**
	 * Move to the next entity in the collection (implementation required by Iterator Interface)
	 */
	public function next() {
		next($this->_entities);
		return $this;
	}
	
	/**
	 * проход по элементам
	 */
	public function walk() {
		$key = key($this->_entities);
		$val = current($this->_entities);
		$this->next();
		$this->lastKey = $key;
		return $val;
	}

	/**
	 * Get the key of the current entity in the collection (implementation required by Iterator Interface)
	 */
	public function key() {
		return key($this->_entities);
	}
	
	public function getLastKey(){
		return $this->lastKey;
	}

	/**
	 * Check if there’re more entities in the collection (implementation required by Iterator Interface)
	 */
	public function valid() {
		return ($this->current() !== false);
	}
	
	public function reset() {
		reset($this->_entities);
		return $this;
	}

	/**
	 * Count the number of entities in the collection (implementation required by Countable Interface)
	 */
	public function count() {
		return count($this->_entities);
	}

	/**
	 * Add an entity to the collection (implementation required by ArrayAccess interface)
	 */
	public function offsetSet($entity,$key = null) {
		
		if (!$entity instanceof AbstractEntity ) {
			throw new Exceptions\Collection("The specified entity is not extends AbstractEntity for this collection.");
		}
		
		if ($entity instanceof $this->_entityClass) {
			
			if(empty($key)){
				$key = md5(serialize($entity));
			}
			
			if (!isset($key)) {
				$this->_entities[] = $entity;
			} else {
				$this->_entities[$key] = $entity;
			}
			return true;
		}
		throw new Exceptions\Collection("The specified entity is not allowed for this collection.");
	}

	/**
	 * Remove an entity from the collection (implementation required by ArrayAccess interface)
	 */
	public function offsetUnset($object) {
		if ($object instanceof $this->_entityClass) {
			$key = md5(serialize($object));
			unset($this->_entities[$key]);
			return true;
		}
		
		$key = $object;
		
		if (isset($this->_entities[$key])) {
			unset($this->_entities[$key]);
			return true;
		}
		return false;
	}

	/**
	 * Get the specified entity in the collection (implementation required by ArrayAccess interface)
	 */
	public function offsetGet($key) {
		return isset($this->_entities[$key]) ?
				$this->_entities[$key] :
				null;
	}

	/**
	 * Check if the specified entity exists in the collection (implementation required by ArrayAccess interface)
	 */
	public function offsetExists($key) {
		return isset($this->_entities[$key]);
	}
	
	public function toArray():array{
		return array_map(function($k){
			return $k->toArray();
		},$this->_entities);
	}

    /**
     * @param $value
     * @return mixed
     */
    public function push($value)
    {
        $this->offsetSet($value);
        return $this;
    }

    /**
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }


}
