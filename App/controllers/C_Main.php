<?php


class C_Main extends C_Base
{
    private $input;		// текст для преобразования
    private $result;	// результат

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
//        $mExample = M_Example::Instance();


        $vars = array(
            'input' => $this->input,
            'result' => $this->result);
//            'canUseSecretFunctions' => $mUsers->Can('USE_SECRET_FUNCTIONS'));

        $this->View("rrr",$vars);

        // C_Base.
        parent::OnOutput();

    }
}
