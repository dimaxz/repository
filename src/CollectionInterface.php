<?php
namespace Repo;

/**
 * Interface CollectionInterface
 * @package Repo
 */
interface CollectionInterface extends \Iterator, \ArrayAccess , ExportableInterface{


    /**
     * @param $value
     * @return mixed
     */
    public function push($value);

}