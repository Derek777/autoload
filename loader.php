<?php
spl_autoload_extensions('.php');
spl_autoload_register(function ($class) {
    switch ($class[0]){
        case 'C': include 'App/controllers/' . $class . '.php';
            break;
        case 'M': include 'App/models/' . $class . '.php';
            break;
        case 'V': include 'App/views/' . $class . '.php';
            break;
    }
});