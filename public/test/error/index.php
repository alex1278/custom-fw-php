<?php
/**
 * Error handler
 * 0 - disabled, 1- enabled
 */
define('DEBUG', 1);

class NotFoundException extends Exception{
    public function __construct($message = "", $code = 404)
    {
        parent::__construct($message, $code);
    }
}

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

        error_log("[".date('Y-m-d H:i:s')."] Текст ошибки: {$errstr} | Файл: {$errfile}, | Строка: {$errline}\n===========================\n", 3, __DIR__.'/errors.log');
        $this->displayError($errno, $errstr, $errfile, $errline);
        return true;
    }

    /**
     * обработчик фатальных ошибок (вызов нусуществующей функции и тд.)
     * обрабатывает фатальные ошибки и записыват в лог файл
     */
    public function fatalErrorHandler(){
        $error = error_get_last();
        if(!empty($error) && $error['type'] & (E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)){
            error_log("[".date('Y-m-d H:i:s')."] Текст ошибки: {$error['message']} | Файл: {$error['file']}, | Строка: {$error['line']}\n===========================\n", 3, __DIR__.'/errors.log');
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
//            var_dump($e);
        error_log("[".date('Y-m-d H:i:s')."] Текст ошибки: {$e->getMessage()} | Файл: {$e->getFile()}, | Строка: {$e->getLine()}\n===========================\n", 3, __DIR__.'/errors.log');
        $this->displayError('Исключение', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
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
        if(DEBUG){
            require 'views/dev.php';
        }else{
            require 'views/prod.php';
        }
        die;
    }

}

new ErrorHandler();
$test=1;
//echo $test2;
//echo test();

/**
 * обработка исключений которые не попали в обработчик ошибок
 */
/*
try{
    if(empty($test)){
        throw new Exception('Опа, Исключение.');
    }
}catch(Exception $e){
    var_dump($e);
};
*/
//throw new Exception('Нежданчик!', 404); // иммитируем ошибку. 1 вар
//throw new notFoundException('Страница не найдена'); // иммитируем ошибку через класс наследник, который обявили раннее. 2 вар