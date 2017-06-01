<?php
error_reporting (E_ALL);
session_start();

require_once ('\startup.php');
startup();


print_r($_SESSION);

function dd($arr){
    if(empty($arr)){
        echo "empty";
    }
    if(is_array($arr)){
        echo '<pre>' . print_r($arr, true) . '</pre>';
    }else{
        echo $arr;
    }
    die;
}