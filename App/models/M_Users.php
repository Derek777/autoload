<?php


//
// Менеджер пользователей
//
class M_Users
{
    private static $instance;	// экземпляр класса
    private $M_Base;				// драйвер БД
    private $sid;				// идентификатор текущей сессии
    private $uid;				// идентификатор текущего пользователя
    private $onlineMap;			// карта пользователей online


    //
    // Получение экземпляра класса
    // результат	- экземпляр класса MSQL
    //
    public static function Instance()
    {
        if (self::$instance == null)
            self::$instance = new M_Users();

        return self::$instance;
    }

    //
    // Конструктор
    //
    public function __construct()
    {
//        parent::__construct();
        $this->M_Base = M_Base::Instance();
        $this->sid = null;
        $this->uid = null;
        $this->onlineMap = null;


    }

    public function Login($login, $password)
    {
        // вытаскиваем пользователя из БД
        $user = $this->GetByLogin($login);

        if ($user == null)
            return false;

        $id_user = $user['id_user'];

        // проверяем пароль
//        dd(md5($password));
        if ($user['password'] != md5($password))
            return false;

        // запоминаем имя и md5(пароль)
//        if ($remember)
//        {
            $expire = time() + 3600 * 24 * 100;
            setcookie('login', $login, $expire);
            setcookie('password', md5($password), $expire);
//        }

        // открываем сессию и запоминаем SID
        $this->sid = $this->OpenSession($id_user);

        return true;
    }

    public function Logout()
    {
        setcookie('login', '', time() - 1);
        setcookie('password', '', time() - 1);
        unset($_COOKIE['login']);
        unset($_COOKIE['password']);
        unset($_SESSION['sid']);
        $this->sid = null;
        $this->uid = null;
    }

    public function ClearSessions(){
        $min = date('Y-m-d H:i:s', time() - 60 * 20);
        $t = "time_last < '%s'";
        $where = sprintf($t, $min);
        $this->M_Base->Delete('sessions', $where);
    }

    public function Get($id_user = null)
    {
//         Если id_user не указан, берем его по текущей сессии.
        if ($id_user == null)
            $id_user = $this->GetUid();

        if ($id_user == null)
            return null;

        // А теперь просто возвращаем пользователя по id_user.
        $t = "SELECT * FROM users WHERE id_user = '%d'";
        $query = sprintf($t, $id_user);
        $result = $this->M_Base->Select($query);
        return $result[0];
    }

    public function GetUid(){
        // Проверка кеша.
        if ($this->uid != null)
            return $this->uid;

        // Берем по текущей сессии.
        $sid = $this->GetSid();

        if ($sid == null)
            return null;

        $t = "SELECT id_user FROM sessions WHERE sid = '%s'";
        $query = sprintf($t, addslashes($sid));
        $result = $this->M_Base->Select($query);

        // Если сессию не нашли - значит пользователь не авторизован.
        if (count($result) == 0)
            return null;

        // Если нашли - запоминм ее.
        $this->uid = $result[0]['id_user'];
        return $this->uid;
//        echo "GetUid FUNCTION";
    }

    private function GetSid()
    {
        // Проверка кеша.
        if ($this->sid != null)
            return $this->sid;

        // Ищем SID в сессии.
        $sid = null;


        // Если нашли, попробуем обновить time_last в базе.
        // Заодно и проверим, есть ли сессия там.
        if ($sid != null)
        {
            $session = array();
            $session['time_last'] = date('Y-m-d H:i:s');
            $t = "sid = '%s'";
            $where = sprintf($t, addslashes($sid));
            $affected_rows = $this->M_Base->Update('sessions', $session, $where);

            if ($affected_rows == 0)
            {
                $t = "SELECT count(*) FROM sessions WHERE sid = '%s'";
                $query = sprintf($t, addslashes($sid));
                $result = $this->M_Base->Select($query);

                if ($result[0]['count(*)'] == 0)
                    $sid = null;
            }
        }

        // Нет сессии? Ищем логин и md5(пароль) в куках.
        // Т.е. пробуем переподключиться.
        if ($sid == null && isset($_COOKIE['login']))
        {
            $user = $this->GetByLogin($_COOKIE['login']);

            if ($user != null && $user['password'] == $_COOKIE['password'])
                $sid = $this->OpenSession($user['id_user']);
        }

        // Запоминаем в кеш.
        if ($sid != null)
            $this->sid = $sid;

        // Возвращаем, наконец, SID.
        return $sid;
    }

    private function OpenSession($id_user)
    {
        // генерируем SID
        $sid = $this->GenerateStr(10);

        // вставляем SID в БД
        $now = date('Y-m-d H:i:s');
        $session = array();
        $session['id_user'] = $id_user;
        $session['sid'] = $sid;
        $session['time_start'] = $now;
        $session['time_last'] = $now;
        $this->M_Base->Insert('sessions', $session);

        // регистрируем сессию в PHP сессии
        $_SESSION['sid'] = $sid;

        // возвращаем SID
        return $sid;
    }

    public function GetByLogin($login = null)
    {
        $t = "SELECT * FROM users WHERE login = '%s'";
        $query = sprintf($t, addslashes($login));
        $result = $this->M_Base->Select($query);

        if(isset($result[0])){
            return $result[0];
        }else{
            return false;
        }
    }

    private function GenerateStr($length = 10)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;

        while (strlen($code) < $length)
            $code .= $chars[mt_rand(0, $clen)];

        return $code;
    }



//    public function Authorization($login, $password){
//        $query = 'SELECT*FROM users WHERE login="'.$login.'" AND password="'.$password.'"';
//        echo $this->link;
//
//        $result = mysqli_query($this->link, $query);
//
//        $user = mysqli_fetch_assoc($result); //преобразуем ответ из БД в нормальный массив
//
//        //Если база данных вернула не пустой ответ - значит пара логин-пароль правильная
//        if (!empty($user)) {
//            //Пользователь прошел авторизацию, выполним какой-то код.
//            return $user;
//        } else {
//            //Пользователь неверно ввел логин или пароль, выполним какой-то код.
//            return false;
//        }
//    }

    public function Can($priv, $id_user = null)
    {
        if ($id_user == null)
            $id_user = $this->GetUid();

        if ($id_user == null)
            return false;

        $t = "SELECT count(*) as cnt FROM privs2roles p2r
			  LEFT JOIN users u ON u.id_role = p2r.id_role
			  LEFT JOIN privs p ON p.id_priv = p2r.id_priv 
			  WHERE u.id_user = '%d' AND p.name = '%s'";

        $query  = sprintf($t, $id_user, $priv);
        $result = $this->M_Base->Select($query);
        return ($result[0]['cnt'] > 0);
    }

    public function Login_validation($login){
        $user_login=strip_tags(trim($login));
        $pattern = "/^[a-z0-9_-]{3,16}$/";
        if(preg_match($pattern, $user_login)){
            return true;
        }else{
            return false;
        }
    }

    public function Email_validation($email){
        $user_email=strip_tags(trim($email));
        $pattern = "/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD";
        if(preg_match($pattern, $user_email)){
            return true;
        }else{
            return false;
        }
    }

    public function Is_login($login){
        $t = "SELECT login FROM users WHERE login = '%s'";
        $query = sprintf($t, $login);
        $result = $this->M_Base->Select($query);
        if(isset($result[0])){
            return true;
        }else{
            return false;
        }
    }

    public function Is_email($email){
        $t = "SELECT email FROM users WHERE email = '%s'";
        $query = sprintf($t, $email);
        $result = $this->M_Base->Select($query);
        if(isset($result[0])){
            return true;
        }else{
            return false;
        }
    }

    public function Add_user($arr){
        $result = $this->M_Base->Insert("users", $arr);
        return $result;
    }

}
