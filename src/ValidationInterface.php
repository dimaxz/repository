<?php


namespace Repo;


interface ValidationInterface
{
    public function errors();

    public function isValid();

    public function getFirstError();
}