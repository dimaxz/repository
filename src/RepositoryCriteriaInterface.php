<?php
namespace Repo;

/**
 * Interface RepositoryCriteriaInterface
 * @package Repo
 */
interface RepositoryCriteriaInterface {


    public function filterById(?int $id);

    public function sortById(?string $sort);

}