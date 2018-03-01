<?php

namespace app\controllers\admin;

use fw\core\base\Controller;

class AppController extends Controller
{
    /**
     * базовый шаблон который можно изменить
     * @var string
     */
    public $layout = 'admin';

    public function __construct($route)
    {
        parent::__construct($route);

        // тестовая проверка (переменные не заданы) для ограниыения доступа в админку, можно сделать переадрессацию на страницу входа
//        if(!isset($is_admin) || $is_admin !==1){
//            die('Access Denied!');
//        }
    }
}