<?php

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 14.02.2018
 * Time: 23:44
 */
class Posts
{
    public function indexAction(){
        echo __CLASS__."::index";
    }

    public function testAction(){
        echo __CLASS__."::test";
    }

    public function testPageAction(){
        echo __CLASS__."::testPage";
    }
}