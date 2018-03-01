<?php

namespace fw\core;


/**
 * Class ErrorHandler
 *
 * обработчик ошибок всех уровней включая Исключения
 */
class ErrorHandler{

    public function __construct(){
        if(DEBUG){
            error_reporting(-1);
        }else{
            error_reporting(0);
        }
        set_error_handler([$this, 'errorHandler']); // перехват данных не фатальных ошибок
        ob_start();
        register_shutdown_function([$this, 'fatalErrorHandler']); // перехватываем данные о Фатальной ошибке
        set_exception_handler([$this, 'exceptionHandler']); // лбработка исключений
    }

    /**
     * аоказываем данные об ошибке и записываем в файл, запись в лог файл будет происходить даже если DEBUG выключен
     * @param $errno - номер ошибки
     * @param $errstr - тип ошибки
     * @param $errfile - путь к файлу где произошла ошибка
     * @param $errline - номер строки ошибки
     *
     * @return bool
     */
    public function errorHandler($errno, $errstr, $errfile, $errline){
        $this->logErrors($errstr, $errfile, $errline);
        if(DEBUG || in_array($errno, [E_USER_ERROR, E_RECOVERABLE_ERROR])){
            $this->displayError($errno, $errstr, $errfile, $errline);
        }
        return true;
    }

    /**
     * обработчик фатальных ошибок (вызов нусуществующей функции и тд.)
     * обрабатывает фатальные ошибки и записыват в лог файл
     */
    public function fatalErrorHandler(){
        $error = error_get_last();
        if(!empty($error) && $error['type'] & (E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)){
            $this->logErrors($error['message'], $error['file'], $error['line']);
            ob_end_clean();
            $this->displayError($error['type'], $error['message'], $error['file'], $error['line']);
        }else{
            ob_end_flush();
        }
    }


    /**
     * обрабвтывает и записывает в файд исключения
     * @param $e closure Exception
     */
    public function exceptionHandler($e){
        $this->logErrors($e->getMessage(), $e->getFile(), $e->getLine());
        $this->displayError('Исключение', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
    }

    protected function logErrors($message='', $file='', $line=''){
        error_log("[".date('Y-m-d H:i:s')."] Текст ошибки: {$message} | Файл: {$file}, | Строка: {$line}\n===========================\n", 3, ROOT.'/tmp/errors.log');
    }
    /**
     * Обработчик ошибок, при условии DEBUG включен или выключен, показываем определённую страницу ошибки
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param $errline
     *
     * @param int $response
     */
    protected function displayError($errno, $errstr, $errfile, $errline, $response = 500){

        http_response_code($response);
        if($response == 404 && !DEBUG){
            require WWW . '/errors/404.html';
            die;
        }
        if(DEBUG){
            require WWW . '/errors/dev.php';
        }else{
            require WWW . '/errors/prod.php';
        }
        die;
    }

}
