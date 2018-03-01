<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 17.02.2018
 * Time: 21:19
 */

namespace app\controllers;


use app\models\Main;
use fw\core\base\Controller;

class AppController extends Controller
{
    public $menu;
    public $meta = [];
    public function __construct($route){
        parent::__construct($route);
        new Main();
//        debug($this->route);
//        if($this->route['controller'] == 'Main'){ // для теста
//            echo '<h2>Controller MAIN</h2>';
//            if($this->route['action'] == 'test'){
//                echo "<h3>Action TEST</h3>";
//            }
//        }
        $this->menu = \R::findAll('category');
    }

    /**
     *
     * создаём мета данные для хедера
     * @param string $title
     * @param string $desc
     * @param string $keywords
     */
    protected function setMeta($title='', $desc = '', $keywords =''){
        $this->meta['title'] = $title;
        $this->meta['desc'] = $desc;
        $this->meta['keywords'] = $keywords;
    }

}