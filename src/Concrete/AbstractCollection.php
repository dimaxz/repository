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

    protected array $_entities = [];

    protected string|null $lastKey;

    /**
     * @var int
     */
    protected int $foundRows = 0;

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
    public function rewind(): void
    {
        reset($this->_entities);
    }

    /**
     * Get the current entity in the collection (implementation required by Iterator Interface)
     */
    public function current(): mixed
    {
        return current($this->_entities);
    }

    public function next(): void
    {
        next($this->_entities);
    }

    public function walk(): ?AbstractEntity
    {
        $key = key($this->_entities);
        if (!$val = current($this->_entities)) {
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

    public function valid(): bool
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
    public function count(): int
    {
        return count($this->_entities);
    }

    /**
     * Add an entity to the collection (implementation required by ArrayAccess interface)
     */
    public function offsetSet($entity, $key = null): void
    {

        $className = $this->getEntityClass();

        if (!is_a($entity, $className)) {
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
    }

    /**
     * Remove an entity from the collection (implementation required by ArrayAccess interface)
     */
    public function offsetUnset($object): void
    {
        $className = $this->getEntityClass();

        if ($object instanceof $className) {
            $key = spl_object_hash($object);
            unset($this->_entities[$key]);
        }

        $key = $object;

        if (isset($this->_entities[$key])) {
            unset($this->_entities[$key]);
        }
    }

    /**
     * Get the specified entity in the collection (implementation required by ArrayAccess interface)
     */
    public function offsetGet($key): mixed
    {
        return $this->_entities[$key]?? null;
    }

    /**
     * Check if the specified entity exists in the collection (implementation required by ArrayAccess interface)
     */
    public function offsetExists($key):bool
    {
        return isset($this->_entities[$key]);
    }

    public function toArray(): array
    {
        return array_map(function ($k) {
            return $k->toArray();
        }, $this->_entities);
    }

    public function push(EntityInterface $value): CollectionInterface
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
