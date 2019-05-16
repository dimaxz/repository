<?php
/**
 * Created by PhpStorm.
 * User: d.lanec
 * Date: 15.05.2019
 * Time: 15:42
 */

namespace Repo\Concrete;

use Repo\EntityInterface;

/**
 * Базовый класс общих методов
 * Class AbstractCrudRepository
 * @package Repo\Concrete
 */
abstract class AbstractCrudRepository
{
    /**
     * @param EntityInterface $entity
     */
    public function delete(EntityInterface $entity) {

        $this->adapter->delete(self::TABLE_NAME, sprintf("%s=%s", self::KEY_NAME, $entity->getId()));

    }
}