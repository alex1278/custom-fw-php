<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 21.02.2018
 * Time: 1:00
 */

namespace fw\libs;

/**
 * Class Cache
 *
 * @package vendor\libs
 *
 * кеширование данных которые могут оставаться актуальными длительное время с цулью снизить количество запросов к базе данных
 */
class Cache
{
    public function __construct(){

    }

    /**
     * @param $key - название данных которые попадают в кэш (постыб меню)
     * $key - название файла принято хранить в хешированном виде
     *
     * @param $data - сами данные которые будут кешироваться
     * @param int $seconds - время на которое кушируются данные, по умолчанию 3600сек - 1час
     */
    public function set($key, $data, $seconds = 3600){
        $content['data'] = $data;
        $content['end_time'] = time() + $seconds;
        if(file_put_contents(CACHE . '/' . md5($key) . '.txt', serialize($content))){
            return true;
        }else{
            return false;
        }

    }

    public function get($key){
        $file = CACHE . '/'.md5($key).'.txt';
        if(file_exists($file)){
            $content = unserialize(file_get_contents($file));
            if(time() <= $content['end_time']){
                return $content['data'];
            }
            unlink($file);
        }
        return false;
    }

    public function delete($key){
        $file = CACHE . '/'.md5($key).'.txt';
        if(file_exists($file)){
            unlink($file);
        }
    }

}