<?php
echo $query = rtrim($_SERVER['QUERY_STRING'], '/');

// define constants
define('WWW', __DIR__); // current directory 'public'
define('CORE', dirname(__DIR__).'/vendor/core'); // core
define('ROOT', dirname(__DIR__)); //root directory on server
define('APP', dirname(__DIR__).'/app'); // app


require '../vendor/core/Router.php';
require '../vendor/libs/functions.php';
//require '../app/controllers/Main.php';
//require '../app/controllers/Posts.php';
//require '../app/controllers/PostsNew.php';

spl_autoload_register(function($class){
    $file = APP."/controllers/$class.php";
    if(file_exists($file)){
        require_once $file;
    }
});

Router::add('^pages/?(?P<action>[a-z-]+)?$', ['controller' => 'Posts']);

// default routes
Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

debug(Router::getRoutes());

Router::dispatch($query);
