<?php

namespace vendor\core;

/**
 * Class Db
 *
 * @package vendor\core
 */
class Db
{
    protected $pdo;
    protected static $instance;
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
        $db = require ROOT.'/config/config_db.php';
        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ];

        $this->pdo = new \PDO($db['dsn'], $db['user'], $db['pass'], $options);
    }

    public static function instance(){
        if(self::$instance === null){
            self::$instance = new self; // если объект класа не был создан, запишем в свойство новый объект класса
        }
        return self::$instance;
    }

    /**
     * проверка выполнения запроса (true / false)
     * @param $sql
     * @return bool
     */
    public function execute($sql, $params = [ ]){
        self::$countSql++;
        self::$queries[] = $sql;
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * будет подготавливать и выполнять обычный SQL запрос, возвращать данные (SELECT и тд.)
     * @param $sql
     */
    public function query($sql, $params = []){
        self::$countSql++;
        self::$queries[] = $sql;
        $stmt = $this->pdo->prepare($sql);
        $res = $stmt->execute($params);
        if($res !== false){
            return $stmt->fetchAll();
        }
        return []; // что бы метод не возвращал false вернём пустой массив
    }
}