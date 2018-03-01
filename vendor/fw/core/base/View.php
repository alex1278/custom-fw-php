<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 17.02.2018
 * Time: 20:44
 */

namespace fw\core\base;


class View
{
    /**
     * pattern MVC
     * View from MVC pattern
     *
     * текущий маршрутизатор и параметры (controller, action, params)
     * @var array
     */
    public $route;
    /**
     * текущий вид
     * @var string
     */
    public $view = [];
    /**
     * текущий шаблон
     * @var string
     */
    public $layout;

    /**
     * хранит скрипты выбранные регулярным выражением
     * @var array
     */
    public $scripts = [];

    public static $meta = ['title' => '', 'desc' => '', 'keywords' => ''];
    public function __construct($route, $layout = '', $view=''){
        $this->route = $route;
        if($layout === false){
            // если layout === false не подключаем ничего - просто выводим данные
            $this->layout = false;
        }else{
            $this->layout = $layout ?: LAYOUT;
        }
        $this->view = $view;
    }

    public function render($vars){
        if(is_array($vars)) extract($vars);
        $this->route['prefix'] = str_replace('\\', '/', $this->route['prefix']);
        $file_view = APP."/views/{$this->route['prefix']}{$this->route['controller']}/{$this->view}.php";
        ob_start();
        if(is_file($file_view)){
            require $file_view;
        }else{
//            echo "<p>Не найден вид <b>$file_view</b></p>";
            throw new \Exception("<p>Не найден вид <b>$file_view</b></p>", 404);
        }

        $content = ob_get_clean();
        if(false != $this->layout) {
            $file_layout = APP . "/views/layouts/{$this->layout}.php";
            if (is_file($file_layout)) {
                $content = $this->getScript($content);
                $scripts = [];
                if(!empty($this->scripts[0])){
                    $scripts = $this->scripts[0];
                }
                require $file_layout;
            } else {
//                echo "<p>Не найден шаблон <b>$file_view</b></p>";
                throw new \Exception("<p>Не найден шаблон <b>$file_view</b></p>",404);

            }
        }
    }

    /**
     * проверяется контент перед выводом через фильтр по регулярному выражению выбираются все скрипты -> выризаются -> сохраняются в переменнуб $scripts. Дальше возвращается контент без скриптов
     * @param $content
     * @return mixed
     */
    protected function getScript($content){
        $pattern = "#<script.*?>.*?</script>#si";
        preg_match_all($pattern, $content, $this->scripts);
        if(!empty($this->scripts)){
            $content = preg_replace($pattern, '', $content);
        }
        return $content;
    }

    public static function getMeta(){
        echo '<title>'.self::$meta['title'].'</title>
        <meta name="description" content="'.self::$meta['desc'].'">
        <meta name="keywords" content="'.self::$meta['keywords'].'">';
    }


    /**
     * создаём мета данные для хедера
     *
     * @param string $title
     * @param string $desc
     * @param string $keywords
     */
    public static function setMeta($title='', $desc = '', $keywords =''){
        self::$meta['title'] = $title;
        self::$meta['desc'] = $desc;
        self::$meta['keywords'] = $keywords;
    }


}