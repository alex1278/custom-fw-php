<?php

namespace fw\core;
use R;

/**
 * Class Db
 * pattern Singleton
 * @package vendor\core
 */
class Db
{
    use TSingletone; // используем трейт, вставлят кусочек кода

    protected $pdo;

    /**
     * считаем общее количество запросов ы базу
     * @var int
     */
    public static $countSql = 0;

    /**
     * сохраняем все запросы в базу
     * @var array
     */
    public static $queries = [];


    protected function __construct(){
        $db = require ROOT . '/config/config_db.php';
        require LIBS.'/rb.php';
        R::setup($db['dsn'], $db['user'], $db['pass']);
        R::freeze(true);
//        R::fancyDebug(TRUE);
        // Не нужно если используем ReadBeanPHP
//        $options = [
//            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
//            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
//        ];
//        $this->pdo = new \PDO($db['dsn'], $db['user'], $db['pass'], $options);
    }

    /**
     * // Не нужно если используем ReadBeanPHP
     * проверка выполнения запроса (true / false)
     * @param $sql
     * @return bool
     */
//    public function execute($sql, $params = [ ]){
//        self::$countSql++;
//        self::$queries[] = $sql;
//        $stmt = $this->pdo->prepare($sql);
//        return $stmt->execute($params);
//    }

    /**
     * // Не нужно если используем ReadBeanPHP
     * будет подготавливать и выполнять обычный SQL запрос, возвращать данные (SELECT и тд.)
     * @param $sql
     */
//    public function query($sql, $params = []){
//        self::$countSql++;
//        self::$queries[] = $sql;
//        $stmt = $this->pdo->prepare($sql);
//        $res = $stmt->execute($params);
//        if($res !== false){
//            return $stmt->fetchAll();
//        }
//        return []; // что бы метод не возвращал false вернём пустой массив
//    }
}