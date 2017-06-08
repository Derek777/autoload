<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 10.05.2017
 * Time: 18:07
 */
class View
{
    public $template_view = null;
    private static $instance;



    public static function Instance()
    {
        if (self::$instance == null)
            self::$instance = new View();

        return self::$instance;
    }

    public function Generate($fileName, $vars = array())
    {
//        print_r($vars);
        foreach ($vars as $k => $v)
            $$k = $v;

$content = $fileName;
        require_once 'App/views/main_tpl.php';
//        require_once 'App/views/' . $fileName . '.php';
    }
# первый параметр функции подключает внутри шаблона нужный контент
}