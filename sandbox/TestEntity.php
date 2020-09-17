<?php
/**
 * Created by PhpStorm.
 * User: d.lanec
 * Date: 17.09.2020
 * Time: 11:49
 */

class TestEntity implements \Repo\EntityInterface
{

    protected $id;

    /**
     * @var DateTime
     */
    protected $dateTime;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return TestEntity
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


    /**
     * @return DateTime
     */
    public function getDateTime(): DateTime
    {
        return $this->dateTime;
    }

    /**
     * @param DateTime $dateTime
     * @return TestEntity
     */
    public function setDateTime(DateTime $dateTime): TestEntity
    {
        $this->dateTime = $dateTime;
        return $this;
    }

}