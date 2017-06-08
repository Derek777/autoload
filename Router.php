<?php


class Router
{
    public function start(){
        $route = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        $routing = [
            "/" => ['controller' => "C_Main", 'action' => 'index'],
            "/article" => ['controller' => "C_File", 'action' => 'index'],
            "/login" => ['controller' => "C_Login", 'action' => 'index'],
            "/create" => ['controller' => "C_Create", 'action' => 'index'],
            "/account" => ['controller' => "C_Account", 'action' => 'index']
        ];

        if(isset($routing[$route])){
            $controller = $routing[$route]['controller'];
            $controller_obj = new $controller();
            $controller_obj->$routing[$route]['action']();
        }else{
            echo 'Now way';
        }
    }
}