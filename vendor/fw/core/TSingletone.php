<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 23.02.2018
 * Time: 0:55
 */

namespace fw\core;

/**
 * Trait TSingletone
 *
 * шаблон паттерна Singletone
 * Trait - сниппет кода, часто повторяемый код
 * @package vendor\core
 */
trait TSingletone
{
    protected static $instance;

    /**
     * singletone pattern
     * @return Db
     */
    public static function instance(){
        if(self::$instance === null){
            self::$instance = new self; // если объект класа не был создан, запишем в свойство новый объект класса
        }
        return self::$instance;
    }

}