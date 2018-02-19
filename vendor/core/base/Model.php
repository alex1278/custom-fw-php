<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 18.02.2018
 * Time: 15:29
 */

namespace vendor\core\base;

use vendor\core\Db;

/**
 * Class Model
 *
 * @package vendor\core\base
 */
class Model
{
    protected $pdo;
    protected $table;

    /**
     * певичный ключ в базе данных
     * @var string
     */
    protected $pk = 'id';

    /**
     * сохраняем обьект базы данных
     * Model constructor.
     */
    public function __construct(){
        $this->pdo = Db::instance();
    }

    /**
     * проверить выполнение запроса и вернуть true / false
     * @param $sql
     */
    public function query($sql){
        return $this->pdo->execute($sql);
    }

    /**
     * select all from table
     * @return mixed
     */
    public function findAll(){
        $sql = "SELECT * FROM {$this->table}";
        return $this->pdo->query($sql);
    }

    /**
     * @param $id
     * @param $field указывает по какому полю хотим выбирать данные
     * @return mixed
     */
    public function findOne($id, $field = ''){
        $field = $field ?: $this->pk;
        $sql = "SELECT * FROM {$this->table} WHERE $field = ? LIMIT 1";
        return $this->pdo->query($sql, [$id]);
    }

    public function findBySql($sql, $params = []){
        return $this->pdo->query($sql, $params);
    }

    public function findLike($str, $field, $table = ''){
        $table = $table ?: $this->table;
        $sql = "SELECT * FROM $table WHERE $field LIKE ?";
        return $this->pdo->query($sql, ['%'.$str.'%']);
    }


}