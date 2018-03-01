<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 21.02.2018
 * Time: 22:38
 */

namespace fw\core;


/**
 * Pattern Registry
 *
 * Autoload new component objects from config\config.php
 */
class Registry
{
    use TSingletone; // используем трейт, вставлят кусочек кода

    public static $objects = [];


    /**
     * Registry constructor.
     *
     * autoload Class Objects
     */
    protected function __construct(){
        require_once ROOT . '/config/config.php';
        foreach($config['components'] as $name => $component){
            self::$objects[$name] = new $component;
        }
    }

    /**
     * magic php function
     * вызывается в случае если была попытка обратиться к не существующему свойству объекта
     *
     * возврвщвет текущий объект
     *
     * @param $name
     */
    public function __get($name){
        if(is_object(self::$objects[$name])){
            return self::$objects[$name];
        }
    }

    /**
     * magic php function
     * вызывается когда мы пытаемся что-то записать в не определённое (не существующее) свойство объекта
     *
     * добавляем в массив объектов $objects новый обьект если он еще не был создан
     * @param $name
     * @param $value
     */
    public function __set($name, $object){
        if(!isset(self::$objects[$name])){
            self::$objects[$name] = new $object;
        }
    }


    public function getList(){
        echo '<pre>';
        var_dump(self::$objects);
        echo '</pre>';
    }


}