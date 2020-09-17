<?php

require_once __DIR__ . '/../vendor/autoload.php';

trait TestHelper
{
    /**
     * получение защищенного свойства
     *
     * @param mixed $o
     * @param string $name
     *
     * @return ReflectionProperty
     * @throws ReflectionException
     */
    protected function getProtectedAttribute($o, $name): \ReflectionProperty
    {
        // создаем reflectionClass
        $reflectionClass = new \ReflectionClass($o);
        
        // получаем свойство
        $r = $reflectionClass->getProperty($name);
        // делаем открытым
        $r->setAccessible(true);

        return $r;
    }

    /**
     * Добавление значения в защищенный метод
     *
     * @param string $name
     * @param mixed $value
     *
     * @throws ReflectionException
     */
    private function setValueprotectedProperty($name, $value)
    {
        // создаем reflectionClass
        $reflectionClass = new \ReflectionClass($this->object);
        
        // получаем свойство
        $r = $reflectionClass->getProperty($name);
        // делаем открытым
        $r->setAccessible(true);
        // изменяем значение
        $r->setValue($this->object, $value);
    }
}
