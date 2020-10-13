<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Repo\Concrete\Exceptions;

/**
 * Description of Registration
 *
 * @author d.lanec
 */
class ValidationException extends \RuntimeException
{

    protected $errors = [];

    function __construct($errors = [])
    {
        $this->errors = (array)$errors;
        parent::__construct("validation errors");
    }

    function getErrors()
    {
        return $this->errors;
    }

    /**
     * Получеание первой ошибки из всех
     * @return string
     */
    public function getFirstError()
    {
        return array_shift($this->errors);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return implode(",", $this->errors);
    }

}