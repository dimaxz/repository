<?php
namespace Repo;

use Repo\CollectionInterface;
use Repo\EntityInterface;

/**
 * Interface CrudRepositoryInterface
 * @package Repo
 */
interface CrudRepositoryInterface {

    public function findByCriteria(PaginationInterface $criteria): CollectionInterface;

    public function count(): int;

    public function save(EntityInterface $entity);

    public function findById(int $id): ?EntityInterface;

    public function delete(EntityInterface $entity);


}