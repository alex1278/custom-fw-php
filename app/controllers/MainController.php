<?php

namespace app\controllers;

use app\models\Main;

class MainController extends AppController
{

//    public $layout = 'main';

    public function indexAction(){
        $model = new Main();
//        $res = $model->query('CREATE TABLE posts SELECT * FROM yii2_mini.post');
        $posts = $model->findAll();
        $post = $model->findOne(2); // find One by Id
//        $data = $model->findBySql("SELECT * FROM {$model->table} ORDER BY id DESC LIMIT 2");
//        $data = $model->findBySql("SELECT * FROM {$model->table} WHERE title LIKE ?", ['%то%']);
        $like = $model->findLike('то', 'title');
        debug($like);
//        $this->layout = false;
//        $this->layout = 'default';
//        $this->view = 'test';

        $title = 'Index Template PAGE TITLE';
        $this->set(compact('title', 'posts'));
    }

}