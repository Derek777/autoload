<?php


class Router
{
    public function start(){
        $route = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        $routing = [
            "/" => ['controller' => "C_Main", 'action' => 'index'],
            "/article" => ['controller' => "C_File", 'action' => 'index']
        ];
//        echo "sssssss";
        if(isset($routing[$route])){
//            echo "ssss";
            $controller = $routing[$route]['controller'];
            $controller_obj = new $controller();
            $controller_obj->$routing[$route]['action']();
        }else{
            echo 'Now way';
        }
    }
}