<?php

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 14.02.2018
 * Time: 0:36
 */
class Router
{
    public function __construct(){
        echo "Hello, World";
    }

    protected static $routes = []; /* arr with all routs */
    protected static $route = [];

    public static function add($regexp, $route = []){
           self::$routes[$regexp] = $route;
    }

    public static function getRoutes(){
        return self::$routes;
    }

    public static function getRoute(){
        return self::$route;
    }

    /*
     * ищет URL в таблице маршрутов
     * @param string $url входящий URL
     * @return boolean
     */
    public static function matchRoute($url){
        foreach(self::$routes as $pattern => $route){
            if(preg_match("#$pattern#i",$url, $matches)){
                foreach($matches as $k => $v){
                    if(is_string($k)){
                        $route[$k] = $v;
                    }
                }
                if(!isset($route['action'])){
                    $route['action'] = 'index';
                }
                self::$route = $route;
                debug($matches);
                debug(self::$route);
                return true;
            }
        }
        return false;
    }

    /*
     * перенаправляет URL по корректному маршруту
     * @param string $url входящий URL
     * @return void
     */
    public static function dispatch($url){
        if(self::matchRoute($url)) {
            $controller = self::upperCamelCase(self::$route['controller']);
            if(class_exists($controller)){
                $cObj = new $controller;
                $action = self::lowerCamelCase(self::$route['action']).'Action';
                if(method_exists($cObj, $action)){
                    $cObj->$action();
                }else{
                    echo "Метод <b>$controller::$action</b> не найден!!!";
                }
            }else{
                echo "Контроллер '$controller' не найден!!!";
            }
        }else{
            http_response_code(404);
            include '404.html';
        }
    }


    /*
     * преобразует первую букву слова в Uppercase
     */
    protected static function upperCamelCase($name){
         return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }
    /*
     * преобразует первую букву в Lowercase
     */
    protected static function lowerCamelCase($name){
        return lcfirst(self::upperCamelCase($name));
    }
}