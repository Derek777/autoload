<?php
require_once ('\loader.php');
require_once ('\Router.php');

function startup()
{
    $router = new Router();
    $router->start();

    // Настройки подключения к БД.
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $dbName   = 'test';
//
//    // Языковая настройка.
//    setlocale(LC_ALL, 'ru_RU.CP1251');
    setlocale (LC_ALL,"");
//    // Подключение к БД.
//    mysql_connect($hostname, $username, $password) or die('No connect with data base');
//    mysql_query('SET NAMES cp1251');
//    mysql_select_db($dbName) or die('No data base');
    // подключаемся к серверу
    $link = mysqli_connect($hostname, $username, $password, $dbName)
    or die(mysqli_error_list($link));


    // Открытие сессии.

}