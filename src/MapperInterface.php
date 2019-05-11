<?php

namespace Repo;

/**
 * Interface MapperInterface
 * @package Repo
 */
interface MapperInterface {

    public static function createEntity():EntityInterface;

    public static function buildEntityFromArray(array $row): EntityInterface;
    
}