<?php
error_reporting (E_ALL);
session_start();
require_once ('\startup.php');
startup();


echo "index" . '<br>';
$ttt = new M_User();
$rrr = new C_File();
$mod = new M_User();

echo"WWWWWWWWWWWW";
