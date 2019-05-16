<?php
/**
 * Created by PhpStorm.
 * User: d.lanec
 * Date: 15.05.2019
 * Time: 15:40
 */

namespace Repo\Concrete\Exceptions;


class ForeignKeyConstraintException extends \Exception
{
    protected $tableName;

    function __construct(string $tableName)
    {
        parent::__construct(sprintf("I can not delete or update because of the related table `%s`", $tableName));

        $this->tableName = $tableName;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }
}