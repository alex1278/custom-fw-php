<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 18.02.2018
 * Time: 15:29
 */

namespace fw\core\base;

use fw\core\Db;
use Valitron\Validator;

/**
 * Class Model
 * pattern MVC
 * Model from MVC pattern
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
     * fields data which passed the validation successfully
     * @var array
     */

    public $attributes = [];
    /**
     * ошибки при валидации
     * @var array
     */
    public $errors = [];
    /**
     * правила валидации входных данных
     * @var array
     */
    public $rules = [];
    /**
     * сохраняем обьект базы данных
     * Model constructor.
     */


    public function __construct(){
        $this->pdo = Db::instance();
    }

    /**
     * получаем данные переданные в форме,
     * сверяем имеется ли у нас такое поле которое было переданно пользователем и добавляем их в массив атрибутов
     * @param $data
     */
    public function load($data){
        foreach($this->attributes as $name =>$value){
            if(isset($data[$name])){
                $this->attributes[$name] = $data[$name];
             }
        }
    }


    /**
     * validate fields with defined rules
     * @param $data
     * @return bool
     */
    public function validate($data){
        Validator::langDir(WWW.'/valitron/lang');
        Validator::lang('ru');
        $v = new Validator($data);
        $v->rules($this->rules);
        if($v->validate()){
            return true;
        }else{
            $this->errors = $v->errors();
            return false;
        }
    }

    public function save($table){
        $tbl = \R::dispense(($table));
        foreach($this->attributes as $name => $value){
            $tbl->$name = $value;
        }
        return \R::store($tbl);
    }

    /**
     * show validation errors
     */
    public function getErrors(){
//        debug($this->errors);
        $errors ='<ul>';
        foreach($this->errors as $error){
            foreach($error as $item){
                $errors .="<li>$item</li>";
            }
        }
        $errors .='</ul>';
        $_SESSION['error'] = $errors;
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