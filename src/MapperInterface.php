<?php

namespace Repo;

/**
 * Interface MapperInterface
 * @deprecated
 * @see BuilderInterface
 * @package Repo
 */
interface MapperInterface {

    public static function createEntity():EntityInterface;

    public static function buildEntityFromArray(array $row): EntityInterface;
    
}