<?php
/**
 * Created by PhpStorm.
 * User: d.lanec
 * Date: 11.05.2019
 * Time: 13:38
 */

namespace Repo;


interface ExportableInterface
{

    /**
     * @return array
     */
    public function toArray():array;


    /**
     * @return string
     */
    public function toJson():string;

}