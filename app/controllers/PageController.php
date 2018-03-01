<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 17.02.2018
 * Time: 14:36
 */

namespace app\controllers;


/*
 * Description of Page controller
 */
class PageController extends AppController
{
    public function viewAction(){
        $menu = $this->menu;
        $title = 'PAGE TITLE';
        $this->set(compact('title','menu'));
    }
}