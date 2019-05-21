<?php
namespace Repo;

use Repo\CollectionInterface;
use Repo\EntityInterface;

/**
 * Interface CrudRepositoryInterface
 * @package Repo
 */
interface CrudRepositoryInterface extends SearchRepositoryInterface {

    public function save(EntityInterface $entity);

    public function delete(EntityInterface $entity);

}