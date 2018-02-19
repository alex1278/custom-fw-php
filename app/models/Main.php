<?php

namespace app\models;

use vendor\core\base\Model;

/**
 * Class Main
 *
 * @package app\models
 */
class Main extends Model
{
    public $table = 'posts';
    public $pk = 'id'; // переопределяем  поле поиска по умолчанию
}