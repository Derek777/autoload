<?php


class C_Account extends C_Base
{
    public function __construct()
    {
        parent::__construct();
        $this->needLogin = true;
    }

    protected function OnInput()
    {
        // C_Base.
        parent::OnInput();

    }

    protected function OnOutput(){

        $vars = array();

        $this->View("account",$vars);
    }
}