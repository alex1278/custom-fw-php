<?php

namespace app\controllers;

use app\models\Main;
use fw\core\App;
use fw\core\base\Model;
use fw\core\base\View;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPMailer\PHPMailer\PHPMailer;

class MainController extends AppController
{

//    public $layout = 'main';

    public function indexAction(){

        // composer monolog
        // create a log channel
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler(ROOT.'/tmp/monolog.log', Logger::WARNING));

        // add records to the log
//        $log->warning('Foo');
//        $log->error('Bar');

        // composer mailer
        $mailer = new PHPMailer();

//        \vendor\core\App::$app->getList(); // возвращает сгенерированные обьекты подключаемых классов через конфиг
        \R::fancyDebug(true); // показать выполненные запросы к базе данных
        $model = new Main;
//        trigger_error("E_USER_ERROR", E_USER_ERROR); // test ErrorHandler
//        $res = $model->query('CREATE TABLE posts SELECT * FROM yii2_mini.post');
//        $posts = $model->findAll();
//        $post = $model->findOne(2); // find One by Id
//        $data = $model->findBySql("SELECT * FROM {$model->table} ORDER BY id DESC LIMIT 2");
//        $data = $model->findBySql("SELECT * FROM {$model->table} WHERE title LIKE ?", ['%то%']);
//        $like = $model->findLike('то', 'title');
//        debug($like);
//        $this->layout = false;
//        $this->layout = 'default';
//        $this->view = 'test';

        // получаем данные из кеша, если запрашиваемого файла не существует отправляется запрос в базу данных и создаётся новый файл кеша
        $posts = App::$app->cache->get('posts');
        if(!$posts){
            $posts = \R::findAll('posts');
            App::$app->cache->set('posts', $posts, 3600*2); // 2 часа
        }
        $post = \R::findOne('posts', 'id = 1');
        App::$app->cache->set('posts', $posts);
//        echo date('Y-m-d H:i', time());
//        echo '<br/>';
//        echo date('Y-m-d H:i', 1519335617);
        $menu = $this->menu;
//        $this->setMeta($post->title, $post->description, $post->keywords);
//        $this->setMeta('Main page', 'Описание страницы', 'ключевые слова'); // мета данные без разметки из контроллера
//        $meta = $this->meta;
        View::setMeta('Main page', 'Описание страницы', 'ключевые слова'); // мета данные с HTML разметкой из View
        $this->set(compact('title', 'posts', 'menu', 'meta', 'scripts'));
    }

    public function testAction(){
        if($this->isAjax()){

            $model = new Main();
//            $data = ['answer' => 'Ответ от сервера', 'code' => 200];
//            echo json_encode($data);
            $post = \R::findOne('posts', "id = {$_POST['id']}");
            $this->loadView('_test', compact('post'));
            die; // тестируем ajax запрос. Для отправки запрашиваемых данных нужно остановить дальнейшее выполнение скрипта тспользуя функции die или exit(), или убрать дальнейшее подключение шаблона установив значение $this->layout = false
        }
        $this->layout = 'test';
        $title = 'Test Template PAGE TITLE';
        $this->set(['title'=> $title]);
    }

}