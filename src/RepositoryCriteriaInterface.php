<?php

namespace Repo;

/**
 * Interface RepositoryCriteriaInterface
 * @package Repo
 */
interface RepositoryCriteriaInterface
{


    public function setFilterById(?int $id);

    public function setSortById(?string $sort);

}