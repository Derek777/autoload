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

    public function generate($content_view, $template_view, $data = null)
    {
        require_once 'App/views/'.$template_view;
    }
# первый параметр функции подключает внутри шаблона нужный контент
}