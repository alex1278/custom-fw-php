<?php
error_reporting(-1);

use vendor\core\Router;

$query = rtrim($_SERVER['QUERY_STRING'], '/');

// define constants
define('WWW', __DIR__); // current directory 'public'
define('CORE', dirname(__DIR__).'/vendor/core'); // core
define('ROOT', dirname(__DIR__)); //root directory on server
define('APP', dirname(__DIR__).'/app'); // app
define('LAYOUT', 'default'); // default template

require '../vendor/libs/functions.php';

spl_autoload_register(function($class){
    $file = ROOT.'/'.str_replace('\\', '/',$class).'.php';
    if(file_exists($file)){
        require_once $file;
    }
});

Router::add('^page/?(?P<action>[a-z-]+)/(?<alias>[a-z-]+)$', ['controller' => 'Page']);
Router::add('^page/(?P<alias>[a-z-]+)$', ['controller' => 'Page', 'action' =>'view']);

// default routes
Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

//debug(Router::getRoutes());

Router::dispatch($query);
