<?php
namespace Repo;

use Repo\Concrete\AbstractCollection;
use Repo\Concrete\AbstractEntity;

/**
 * Interface CollectionInterface
 * @package Repo
 */
interface CollectionInterface extends \Iterator, \ArrayAccess , \Countable, ExportableInterface{


    /**
     * @param $value
     * @return mixed
     */
    public function push(EntityInterface $value): CollectionInterface;

}