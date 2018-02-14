<?php

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 15.02.2018
 * Time: 0:08
 */
class PostsNew
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

    public function before(){
        echo __CLASS__."::before";
    }
}