<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 27.02.2018
 * Time: 21:31
 */

namespace app\controllers\admin;


use fw\core\base\View;

class UserController extends AppController
{
    /**
     * можно переопределять
     * @var string
     */
//    public $layout = 'default';

    /**
     * index action, срабатывает по дефолту
     */
    public function indexAction(){
        View::setMeta('Админка | Главная страница', 'Описание Админки', 'Ключевые слова');
        $test = 'Тестовая переменная';
        $data = ['test', '2'];
//        $this->set(['test'=>$test,'data'=>$data]); // I способ передачи переменных
        $this->set(compact('test', 'data')); // II способ передачи переменных
    }

    public function testAction(){
//        $this->layout= 'admin';
    }
}