<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 21.02.2018
 * Time: 22:41
 */

namespace fw\core;


/**
 * Class App
 *
 * load registry object
 * @package vendor\core
 */
class App
{
    public static $app;

    public function __construct(){
        session_start(); //start session
        self::$app = Registry::instance();
        new ErrorHandler();
    }
}