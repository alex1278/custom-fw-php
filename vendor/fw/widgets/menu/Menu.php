<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 26.02.2018
 * Time: 23:28
 */

namespace fw\widgets\menu;


use fw\libs\Cache;

/**
 * Class Menu
 *
 *  Виджет меню, возможность задавать индивидуальные настройки, вывод несколько меню на одной страницу в разных шаблонах. нвстройки и шаблон по умолчанию
 *
 * @package vendor\widgets\menu
 */
class Menu
{
    protected $data;
    protected $tree; // дерево подменю
    protected $menuHtml;
    protected $tpl;
    protected $container = 'ul';
    protected $class = 'menu'; // attribute 'class' for menu container
    protected $table = 'categories'; // table from BD
    protected $cache = 3600; // (1 час) кештрование меню
    protected $cacheKey ='fw_menu'; // куширование для нескольких меню


    public function __construct($options=[]){
        $this->tpl = __DIR__ . '/menu_tpl/menu.php';
        $this->getOptions($options);
        $this->run();
    }

    /**
     * extract and compare options to defaults
     *
     * @param $options
     */
    protected function getOptions($options){
        foreach($options as $k => $v){
            if(property_exists($this, $k)){
                $this->$k = $v;
            }
        }
    }

    /**
     * show menu
     */
    protected function output(){
        echo "<{$this->container} class='{$this->class}'>";
            echo $this->menuHtml;
        echo "</{$this->container}>";
    }
    /**
     *  run menu widget, cache or select menu from DB
     */
    protected function run(){
        if($this->cache !== false){
            $cache = new Cache();
            $this->menuHtml = $cache->get($this->cacheKey);
            if(!$this->menuHtml){
                $this->data = \R::getAssoc("SELECT * FROM $this->table");
                $this->tree = $this->getTree();
                $this->menuHtml = $this->getMenuHtml($this->tree);
                $cache->set($this->cacheKey, $this->menuHtml, $this->cache);
            }
        }else{
            $this->data = \R::getAssoc("SELECT * FROM $this->table");
            $this->tree = $this->getTree();
            $this->menuHtml = $this->getMenuHtml($this->tree);
        }
        $this->output();
    }

    /**
     * generate menu tree
     *
     * @return array
     */
    protected  function getTree(){
        $tree = [];
        $dataset = $this->data;

        foreach ($dataset as $id=>&$node) {
            if (!$node['parent']){
                $tree[$id] = &$node;
            }else{
                $dataset[$node['parent']]['childs'][$id] = &$node;
            }
        }

        return $tree;
    }

    /**
     * generate menu and sublevels
     *
     * @param $tree
     * @param string $tab - разделитель для подпунктов
     * @return string
     */
    protected function getMenuHtml($tree, $tab=''){
        $str='';
        foreach( $tree as $id => $category){
            $str .=$this->catToTemplate($category, $tab, $id);
        }
        return $str;
    }

    /**
     * push data to template
     *
     * @param $category
     * @param $tab
     * @param $id
     * @return string
     */
    protected function catToTemplate($category, $tab, $id){
        ob_start();
        require $this->tpl;
        return ob_get_clean();
    }
}