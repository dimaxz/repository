<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/TestEntity.php';
require_once __DIR__ . '/TestRepository.php';



$repo = new TestRepository();


dump(TestRepository::buildEntityFromArray([
    'id'    => 1,
    'dateTime'  =>  new TestEntity()
]));