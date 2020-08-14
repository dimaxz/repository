<?php

namespace Repo\Concrete;

use Repo\CollectionInterface;
use Repo\Concrete\Exceptions;
use Repo\EntityInterface;

/**
 * Абстрактная коллекция для Enitities
 *
 * @author d.lanec
 */
abstract class AbstractCollection implements CollectionInterface
{

    protected $_entities = array();

    protected $lastKey;

    /**
     * @var int
     */
    protected $foundRows = 0;

    /**
     * Constructor
     */
    public function __construct(array $entities = array())
    {
        if (!empty($entities)) {
            foreach ($entities as $entity) {
                $this->offsetSet($entity);
            }
        }
        $this->rewind();
    }

    /**
     * @return string
     */
    abstract protected function getEntityClass(): string;

    /**
     * @return int
     */
    public function getFoundRows(): int
    {

        return $this->foundRows;
    }

    /**
     * @param int|null $foundRows
     *
     * @return AbstractCollection
     */
    public function setFoundRows(int $foundRows): AbstractCollection
    {

        $this->foundRows = $foundRows;

        return $this;
    }


    /**
     * Get the entities stored in the collection
     */
    public function getEntities()
    {
        return $this->_entities;
    }

    /**
     * Clear the collection
     */
    public function clear()
    {
        $this->_entities = array();
    }

    /**
     * Reset the collection (implementation required by Iterator Interface)
     * @deprecated
     * @see  AbstractCollection::reset()
     */
    public function rewind()
    {
        reset($this->_entities);
        return $this;
    }

    /**
     * Get the current entity in the collection (implementation required by Iterator Interface)
     */
    public function current()
    {
        return current($this->_entities);
    }

    /**
     * Move to the next entity in the collection (implementation required by Iterator Interface)
     * @return AbstractCollection
     */
    public function next(): AbstractCollection
    {
        next($this->_entities);
        return $this;
    }

    /**
     * @return AbstractEntity
     */
    public function walk(): ?AbstractEntity
    {
        $key = key($this->_entities);
        if(!$val = current($this->_entities)){
			return null;
		}
        $this->next();
        $this->lastKey = $key;
        return $val;
    }

    /**
     * @return string
     */
    public function key(): string
    {
        return key($this->_entities);
    }

    /**
     * @return string
     */
    public function getLastKey(): string
    {
        return $this->lastKey;
    }

    /**
     * Check if there’re more entities in the collection (implementation required by Iterator Interface)
     */
    public function valid()
    {
        return ($this->current() !== false);
    }

    /**
     * @return AbstractCollection
     */
    public function reset(): AbstractCollection
    {
        reset($this->_entities);
        return $this;
    }

    /**
     * Count the number of entities in the collection (implementation required by Countable Interface)
     */
    public function count()
    {
        return count($this->_entities);
    }

    /**
     * Add an entity to the collection (implementation required by ArrayAccess interface)
     */
    public function offsetSet($entity, $key = null)
    {

        $className = $this->getEntityClass();

        if (!$entity instanceof $className) {
            throw new Exceptions\Collection("The specified entity is not allowed for this collection.");
        }

        if (empty($key)) {
            $key = spl_object_hash($entity);
        }

        if (!isset($key)) {
            $this->_entities[] = $entity;
        } else {
            $this->_entities[$key] = $entity;
        }

        return true;
    }

    /**
     * Remove an entity from the collection (implementation required by ArrayAccess interface)
     */
    public function offsetUnset($object)
    {
        $className = $this->getEntityClass();

        if ($object instanceof $className) {
            $key = spl_object_hash($object);
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
    public function offsetGet($key)
    {
        return isset($this->_entities[$key]) ?
            $this->_entities[$key] :
            null;
    }

    /**
     * Check if the specified entity exists in the collection (implementation required by ArrayAccess interface)
     */
    public function offsetExists($key)
    {
        return isset($this->_entities[$key]);
    }

    public function toArray(): array
    {
        return array_map(function ($k) {
            return $k->toArray();
        }, $this->_entities);
    }

    /**
     * @param AbstractEntity $value
     * @return $this|mixed
     * @throws Exceptions\Collection
     */
    public function push(EntityInterface $value): AbstractCollection
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
