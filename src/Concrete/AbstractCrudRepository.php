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
    public function delete(EntityInterface $entity): void
    {

        $this->adapter->delete(static::TABLE_NAME, sprintf("%s=%s", static::KEY_NAME, $entity->getId()));

    }

    /**
     * @param SearchCriteria $dbCriteria
     * @param PaginationInterface $criteria
     * @return mixed
     */
    abstract protected function modifyCriteria(PaginationInterface $criteria,SearchCriteria $dbCriteria): void ;

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

        //сортировка не нужна
        $dbCriteria->setOrder([]);

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

    abstract public static function buildEntityFromArray(array $row):\Repo\EntityInterface;

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



            $casted = true;

            
            //если значения нет то загоняем null
            if (empty($value) && $argType && $argType->allowsNull() === true) {
                $entity->{$methodName}(null);
                continue;
            }

            $type = !$argType ? null : $argType->getName();


            switch ($type) {
                case 'bool':
                    $value = (bool)$value;
                    break;
                case 'int':
                    $value = (int)$value;
                    break;
                case 'DateTime':
                    $value = \DateTime::createFromFormat("d/m/Y H:i:s", $value) ?: null;
                    //$value = new \DateTime($value);
                    break;
                case 'float':
                    $value = (float)$value;
                    break;
                case 'string':
                    $value = (string)$value;
                    break;
                case 'array':
                    $value = (array)$value;
                    break;
            }

            $entity->{$methodName}($value);

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
    protected function insertOrUpdate(array $data, EntityInterface $entity): void
    {
        if ($entity->getId() > 0) {
            $this->adapter->update(static::TABLE_NAME, $data, sprintf("%s = %s", static::KEY_NAME, $entity->getId()));
        } else {
            $this->adapter->insert(static::TABLE_NAME, $data);
            $entity->setId($this->adapter->lastInsertId());
        }
    }
}