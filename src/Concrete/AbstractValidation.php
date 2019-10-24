<?php

namespace Repo\Concrete;


use Repo\ValidationInterface;

/**
 * Базовы класс валидации, все нужное тут
 * Class AbstractValidation
 * @package Repo\Concrete
 */
class AbstractValidation implements ValidationInterface
{

    protected $errors = [];

    /**
     * @param string $error
     * @return $this
     */
    protected function addError(string $error)
    {
        $this->errors [] = $error;
        return $this;
    }

    /**
     * @return array
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return count($this->errors) === 0;
    }

    /**
     * @return string|null
     */
    public function getFirstError(): ?string
    {
        return ($this->errors[0] ? $this->errors[0] : null);
    }


}