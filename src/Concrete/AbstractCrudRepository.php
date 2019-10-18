<?php
/**
 * Created by PhpStorm.
 * User: d.lanec
 * Date: 15.05.2019
 * Time: 15:42
 */

namespace Repo\Concrete;

use QueryBuilder\SearchCriteria;
use Repo\EntityInterface;
use Repo\PaginationInterface;

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
    public function delete(EntityInterface $entity)
    {

        $this->adapter->delete(static::TABLE_NAME, sprintf("%s=%s", static::KEY_NAME, $entity->getId()));

    }

    /**
     * @param SearchCriteria $dbCriteria
     * @param PaginationInterface $criteria
     * @return mixed
     */
    abstract protected function modifyCriteria(PaginationInterface $criteria,SearchCriteria $dbCriteria);

    /**
     * кол-во записей
     *
     * @param ShopReviewCriteria $criteria
     *
     * @return int
     */
    public function count(?PaginationInterface $criteria): int
    {

        $dbCriteria = static::buildCriteria()
            ->setManualSelect(sprintf("%s.%s", static::TABLE_NAME , static::KEY_NAME));

        if ($criteria) {
            $this->modifyCriteria($criteria, $dbCriteria);
        }

        $query = sprintf("SELECT count(1) as c FROM (%s) sub",
            $this->adapter->buildQuery(static::TABLE_NAME, $dbCriteria));


        $row = $this->adapter->exuteQuery($query, true);

        return (int)$row["c"];
    }

    /**
     * общий критерий для всех запросов
     * @return SearchCriteria
     */
    public static function buildCriteria(): SearchCriteria
    {

        return (new SearchCriteria());
    }

    abstract public static function createEntity(): \Repo\EntityInterface;

    /**
     * Авто установка значений в объект
     * @param array $dataList
     * @param object $entity
     *
     * @throws \ReflectionException
     */
    protected function autoFillEntity(array $dataList, object $entity = null) : \Repo\EntityInterface
    {
        if($entity === null){
            $entity = static::createEntity();
        }

        $dataList = array_change_key_case($dataList);

        $reflector = new \ReflectionClass($entity);

        foreach ($dataList as $name => $value) {
            $methodName = "set" . $name;
            if (!method_exists($entity, $methodName)) {
                continue;
            }

            $methodInfo = $reflector->getMethod($methodName);

            if ($methodInfo->getNumberOfParameters() != 1) {
                continue;
            }

            $argType = $methodInfo->getParameters()[0]->getType();

            if (empty($argType) || gettype($value) == $argType) {
                $entity->{$methodName}($value);
                continue;
            }
            $casted = true;
            switch ($argType) {
                case 'bool':
                    $value = (bool)$value;
                    break;
                case 'int':
                    $value = (int)$value;
                    break;
                case \DateTime::class:
                    $value = \DateTime::createFromFormat("d/m/Y H:i:s", $value);
                    if ($value === false) {
                        $casted = false;
                    }
                    break;
                case 'float':
                    $value = (float)$value;
                    break;
                case 'string':
                    $value = (string)$value;
                    break;
                default:
                    $casted = false;
                    break;
            }
            if ($casted) {
                $entity->{$methodName}($value);
            }
        }

        return $entity;
    }

    /**
     * Собираем модель из массива post/request
     *
     * @param array $data
     *
     * @return EntityInterface
     */
    public function createEntityFromRequest(array $data, EntityInterface $model = null): EntityInterface
    {

        if (!$model) {
            $model = static::createEntity();
        }

        $this->autoFillEntity($data, $model);

        return $model;
    }

    /**
     * @param int $id
     *
     * @return EntityInterface|null
     */
    public function findById(int $id): ?EntityInterface
    {

        $dbSearchCriteria
            = static::buildCriteria()
            ->setWhere(static::KEY_NAME, $id);
        if (!$row = $this->adapter->getResult(static::TABLE_NAME, $dbSearchCriteria)) {
            return null;
        }
        return static::buildEntityFromArray($row);
    }

    /**
     * создание маппинга модели в массив
     *
     * @param EntityInterface|\Market\Domain\Shop\Shop $entity
     */
    public function createRequestFromEntity(EntityInterface $entity): array
    {

        return $entity->toArray();
    }

    /**
     * update or insert entity
     * @param array $data
     * @param EntityInterface $entity
     */
    protected function insertOrUpdate(array $data, EntityInterface $entity)
    {
        if ($entity->getId() > 0) {
            $this->adapter->update(static::TABLE_NAME, $data, sprintf("%s = %s", static::KEY_NAME, $entity->getId()));
        } else {
            $this->adapter->insert(static::TABLE_NAME, $data);
            $entity->setId($this->adapter->lastInsertId());
        }
    }
}