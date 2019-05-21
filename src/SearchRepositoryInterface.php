<?php
/**
 * Created by PhpStorm.
 * User: d.lanec
 * Date: 21.05.2019
 * Time: 17:03
 */

namespace Repo;


interface SearchRepositoryInterface
{

    public function findById(int $id): ?EntityInterface;

    public function findByCriteria(PaginationInterface $criteria): CollectionInterface;

    public function count(?PaginationInterface $criteria): int;
}