<?php

use fw\core\Router;

$query = rtrim($_SERVER['QUERY_STRING'], '/');

// define constants
define('DEBUG', 1); // Debug mode: 0 - disabled, 1- enabled. Developer mode = 1;
define('WWW', __DIR__); // current directory 'public'
define('CORE', dirname(__DIR__) . '/vendor/fw/core'); // core
define('ROOT', dirname(__DIR__)); //root directory on server
define('LIBS', dirname(__DIR__) . '/vendor/fw/libs'); // libs directory
define('APP', dirname(__DIR__).'/app'); // app
define('CACHE', dirname(__DIR__).'/tmp/cache'); //cache store directory
define('LAYOUT', 'default'); // default template

require '../vendor/fw/libs/functions.php';
require __DIR__ . '/../vendor/autoload.php';

/**
 * автозагрузчик классов ядра
 *
 * при использовании composer он более не нужен, эту функцию выполняет composer из виртуального пространства имен
 * необходимо во всех пространствах имен заменитть путь на тот что указан в composer.json
 */
//spl_autoload_register(function($class){
//    $file = ROOT.'/'.str_replace('\\', '/',$class).'.php';
//    if(file_exists($file)){
//        require_once $file;
//    }
//});

new fw\core\App; // load core App
/**
 * перевыми должны всегда указываться более конкретные правила, далее общие, иначе сначала сработает общее правило.
 */
Router::add('^page/?(?P<action>[a-z-]+)/(?<alias>[a-z-]+)$', ['controller' => 'Page']);
Router::add('^page/(?P<alias>[a-z-]+)$', ['controller' => 'Page', 'action' =>'view']);

// default routes

Router::add('^admin$', ['controller' => 'User', 'action' => 'index', 'prefix' => 'admin']);
Router::add('^admin/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['prefix' => 'admin']);
Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

//debug(Router::getRoutes());

Router::dispatch($query);
