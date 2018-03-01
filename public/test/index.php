<?php

$config =[
    'components' =>[
        'cache' => 'classes\Cache',
        'test' => 'classes\Test',
    ]
];

spl_autoload_register(function($class){
    $file = str_replace('\\', '/',$class).'.php';
    if(file_exists($file)){
        require_once $file;
    }
});

/**
 * Pattern Registry
 *
 * Autoload new component objects from config\config.php
 */
class Registry
{
    public static $objects = [];

    protected static $instance;

    /**
     * Registry constructor.
     *
     * autoload Class Objects
     */
    protected function __construct(){
        global $config;
        foreach($config['components'] as $name => $component){
            self::$objects[$name] = new $component;
        }
    }

    /**
     * singleton pattern
     * @return Registry
     */
    public static function instance(){
        if(self::$instance === null){
            self::$instance = new self; // если объект класа не был создан, запишем в свойство новый объект класса
        }
        return self::$instance;
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

$app = Registry::instance();
$app->getList();

$app->test->go();
$app->test2 = 'classes\Test2';
$app->getList();
$app->test2->hello();
