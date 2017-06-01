<?php


class C_Create extends C_Base
{
    public $login;	// логин пользователя
    public $email;	// пошта користувачаля

    public $filename = '';
    public $uploaddir = 'App/views/avatars/';
    public $err_message = '';
    public $base_avatar = '12345.jpg';


    public function __construct()
    {
        parent::__construct();
        $this->login = '';
        $this->email = '';
    }

    protected function OnInput()
    {
        // Выход из системы пользователя.
        $mUsers = M_Users::Instance();
        $mUsers->Logout();

        // C_Base.
        parent::OnInput();

        if ($this->IsPost()){

            $this->login = $_POST['login'];
            $this->email = $_POST['email'];

            if(!empty($_POST['login']) &&
               !empty($_POST['email']) &&
               !empty($_POST['password']) &&
               !empty($_POST['password-dublicate']))
            {
                while (true){
                    if(!$mUsers->Login_validation($this->login)){
                        $this->err_message = "Login not correct";
                        break;
                    }
                    if(!$mUsers->Email_validation($this->email)){
                        $this->err_message = "Email not correct";
                        break;
                    }
                    if($mUsers->Is_login($this->login)){
                        $this->err_message = "Login exist";
                        break;
                    }
                    if($mUsers->Is_email($this->email)){
                        $this->err_message = "User with email exist";
                        break;
                    }
                    if(!$_POST['password'] === $_POST['password-dublicate']){
                        $this->err_message = "Wrong password";
                        break;
                    }else{

                        $password = md5($_POST['password']);//Пароль

                        $this->filename = $_FILES['avatar']['name'];//Ім"я файла
                        $uploaddir = $this->uploaddir;//Шлях до папки з аватарками
                        $uploadfile = $uploaddir . basename($this->filename);//Шлях до аватарки

                        $avatar = $uploadfile == $uploaddir ? $uploadfile . $this->base_avatar : $uploadfile;//аватарка
                        $psth_info = pathinfo($avatar);
                        $end = $psth_info['extension'];//Розширення файлу аватарки
                        $str = strtolower($end);

                        if(strlen($password)<5){
                            $this->err_message = "Short password";
                            break;
                        }

                        if($_FILES['avatar']['size']>6000000){
                            $this->err_message = "Veri big file";
                            break;
                        }

                        if(!(($str) == "jpg" || $str == "gif" || $str == "jpeg")){

                        }

                        move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadfile);


                        $time = time();
                        $ip = $_SERVER['REMOTE_ADDR'];
                        $brouser = $_SERVER['HTTP_USER_AGENT'];
                        $arr = array(   "login"=>$this->login,
                                        "email"=>$this->email,
                                        "password"=>$password,
                                        "user_ip"=>$ip,
                                        "browser"=>$brouser,
                                        "avatar"=>$avatar,
                                        "date"=>$time);


                        $result = $mUsers->Add_user($arr);
                        if($result){
                            $this->err_message = "You create account";
                            break;
                        }else{
                            $this->err_message = "Account creating error";
                            break;
                        }
                    }
                    break;
                }
            }else{
                if(empty($_POST['login'])){
                    $this->err_message = "Error login";
                }
                if(empty($_POST['mail'])){
                    $this->err_message = "Error email";
                }
                if(empty($_POST['password'])){
                    $this->err_message = "Error password";
                }
                if(empty($_POST['password-dublicate'])){
                    $this->err_message = "Error password 2";
                }
            }
        }
    }

    protected function OnOutput()
    {
        // Генерация содержимого формы входа.
        $vars = array(
            'login' => $this->login,
            'email' => $this->email,
            'err_message' => $this->err_message
        );
        $this->View("create",$vars);

        // C_Base.
        parent::OnOutput();
    }
}