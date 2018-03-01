<?php
require 'rb.php';
$db = require '../config/config_db.php';
R::setup($db['dsn'], $db['user'], $db['pass'], $options);
R::freeze(true);
R::fancyDebug(TRUE);
//var_dump(R::testConnection());

// CRUD
// 1. Create
//$cat = R::dispense('category');
//$cat->title = 'Category 6 dkj';
//$cat->excerpt = 'Text for category 6 lsdkfdjfhfas dsjfhklsjfag';
//var_dump($cat);
//$id = R::store($cat);
//var_dump($id);

// 2. READ
//$cat = R::load('category', 2);
//echo $cat['title']; // $cat->title; /* С выбранными из базы данными можно работать как с обьктом так и с массивом */

// 3.UPDATE
//$cat = R::load('category', 3);
//echo $cat->title.'<br>';
//$cat->title = 'Category 3';
//$id = R::store($cat);
//echo $cat->title;

// II Способ изменения данных в базе
//$cat = R::dispense('category');
//$cat->title = 'Category3 !!!';
//$cat->id = 3;
//R::store($cat);

// 4. DELETE
//$cat = R::load('category', 2);
//R::trash($cat); // delete field

//R::wipe('category');// delete all fields from table


//$cats = R::findAll('category');
//$cats = R::findAll('category', 'id>?', [4]);
//$cats = R::findAll('category', 'title LIKE ?', ['%cat%']);

$cat = R::findOne('category', 'id=?', [2]);

print '<pre>';
print_r($cat);
