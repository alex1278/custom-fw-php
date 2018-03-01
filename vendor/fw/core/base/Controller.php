<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 17.02.2018
 * Time: 14:32
 */

namespace fw\core\base;


abstract class Controller
{
    /**
     * abstract class
     * pattern MVC
     * Controller from MVC pattern
     *
     * текущий маршрутизатор и параметры (controller, action, params)
     * @var array
     */
    public $route = [];
    /**
     * вид
     * @var string
     */
    public $view;

    /**
     * текущий шаблон
     * @var string
     */
    public $layout;

    /**
     * пользовательские данные, передаём переменные в вид
     * @var array
     */
    public $vars =[];

    public function __construct($route){
        $this->route = $route;
        $this->view = $route['action'];
    }

    public function getView(){
        $vObj = new View($this->route, $this->layout, $this->view);
        $vObj->render($this->vars);
    }

    public function set($vars){
        $this->vars = $vars;
    }

    /**
     * проверка на Ajax запрос(из Yii2)
     *
     * @return bool
     */
    public function isAjax(){
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    /**
     * Предназначен для Ajax запросов
     * загружает вид и передаёт в него параметры
     *
     * @param $view
     * @param array $vars
     */
    public function loadView($view, $vars = []){
        extract($vars);
        require APP."/views/{$this->route['controller']}/{$view}.php";
    }
}