<?php


class C_Main
{
    public function __construct()
    {

    }

    public function index(){
        echo "connect...";
        $fff = new M_User();
        $fff->hoho();
    }
}