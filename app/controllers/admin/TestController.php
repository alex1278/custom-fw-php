<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 27.02.2018
 * Time: 21:37
 */

namespace app\controllers\admin;



class TestController extends AppController
{
    public function indexAction(){
        echo __METHOD__;
    }

    public function testAction(){
        echo __METHOD__;
    }
}