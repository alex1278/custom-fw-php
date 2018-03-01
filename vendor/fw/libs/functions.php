<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 14.02.2018
 * Time: 0:58
 */

function debug($arr){
    echo '<pre>'.print_r($arr, true).'</pre>';
}

/**
 * redirect
 *
 * @param bool $http
 */
function redirect($http = false){
    if($http){
        $redirect = $http;
    }else{
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
    }
    header("Location: $redirect");
    exit;
}

function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}