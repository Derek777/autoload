<?php

class C_Login extends C_Base
{
    public $login;	// логин пользователя

    //
    // Конструктор.
    //
    public function __construct()
    {
        parent::__construct();
        $this->login = '';
    }

    //
    // Виртуальный обработчик запроса.
    //
    protected function OnInput()
    {
        // Выход из системы пользователя.
        $mUsers = M_Users::Instance();
        $mUsers->Logout();
        $mBase = M_Base::Instance();


        // C_Base.
        parent::OnInput();

        // Обработка отправки формы.
        if ($this->IsPost())
        {
            $this->login = $_POST['login'];
            if ( !empty($_POST['password']) and !empty($_POST['login']) ){
                $login = $_POST['login'];
                $password = $_POST['password'];
                $user_login = $mUsers->Authorization($login, $password);
                if($user_login){
                    header('Location: /');
                    die();
                }else{
                    echo "NOT GOOD";
                }
            }


//            $mUsers->run();
//                $mBase->get();
        }else{
//
        }
    }

    //
    // Виртуальный генератор HTML.
    //
    protected function OnOutput()
    {
        // Генерация содержимого формы входа.
        $vars = array('login' => $this->login);
//        $this->content = $this->View('tpl_login.php', $vars);
        $this->View("login",$vars);

        // C_Base.
        parent::OnOutput();
    }
}