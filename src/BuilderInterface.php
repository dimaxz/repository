<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 15.08.2020
 * Time: 15:19
 */

namespace Repo;


interface BuilderInterface
{
    public static function createEntity():EntityInterface;

    public function buildEntityFromArray(array $row, EntityInterface $entity = null): EntityInterface;
}