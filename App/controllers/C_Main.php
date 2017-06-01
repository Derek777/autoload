<?php


class C_Main extends C_Base
{
    private $input;		// текст для преобразования
    private $result;	// результат

    public function __construct()
    {
        parent::__construct();
//        $this->needLogin = true;
    }

    protected function OnInput()
    {
        // C_Base.
        parent::OnInput();

        // Менеджеры.
//        $mUsers = M_Users::Instance();
        $mExample = M_Example::Instance();

        // Обработка отправки формы.
        if ($this->IsPost())
        {
            $this->input = $_POST['input'];

            if ($_POST['secret'])
            {
                // проверку наличия привилегии здесь не делаем, так как она
                // зашита в модель
                $this->result = $mExample->MakeSecretMagic($this->input);
            }
            else
            {
                $this->result = $mExample->MakeMagic($this->input);
            }
        }
        else
        {
//            $this->input = 'Пример';
//            $this->result = null;
        }
    }

    protected function OnOutput(){



        $mUsers = M_Users::Instance();
//        $mExample = M_Example::Instance();

        parent::OnOutput();

//        $ee =$mUsers->Can('USE_SECRET_FUNCTIONS');
//        echo $ee;
//        die();
        $vars = array(
            'input' => $this->input,
            'result' => $this->result,
            'user' => $this->user,
            'canUseSecretFunctions' => $mUsers->Can('USE_SECRET_FUNCTIONS'));

        $this->View("main",$vars);


        // C_Base.


    }
}
