<?php


class C_Main extends C_Base
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        echo "connect...";

        $this->OnOutput();

    }

    protected function OnOutput(){
//        $mUsers = M_Users::Instance();

        // Генерация содержимого страницы Welcome.
//        $vars = array(
//            'input' => $this->input,
//            'result' => $this->result,
//            'canUseSecretFunctions' => $mUsers->Can('USE_SECRET_FUNCTIONS'));


        $arr = [11, 22, 33, 44, 55];

        $this->View("rrr",$arr);

        // C_Base.
        parent::OnOutput();

    }
}
