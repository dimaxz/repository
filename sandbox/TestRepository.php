<?php
/**
 * Created by PhpStorm.
 * User: d.lanec
 * Date: 17.09.2020
 * Time: 11:54
 */

class TestRepository extends \Repo\Concrete\AbstractCrudRepository
{
    protected function modifyCriteria(\Repo\PaginationInterface $criteria, \QueryBuilder\SearchCriteria $dbCriteria): void
    {
        // TODO: Implement modifyCriteria() method.
    }

    public static function createEntity(): \Repo\EntityInterface
    {
        return new TestEntity();
    }

    public static function buildEntityFromArray(array $row): \Repo\EntityInterface
    {
        return self::autoFillEntity($row,self::createEntity());
    }


}