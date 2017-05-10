<?php
//
// Базовый контроллер сайта.
//
abstract class C_Base extends Controller
{
    protected $needLogin;	// необходимость авторизации
    protected $user;		// авторизованный пользователь

    private $start_time;	// время начала генерации страницы

    //
    // Конструктор.
    //
    function __construct()
    {
        $this->needLogin = false;
        $this->user = null;
    }

    //
    // Виртуальный обработчик запроса.
    //
    protected function OnInput()
    {
        // Очистка старых сессий и определение текущего пользователя.
        $mUsers = M_Users::Instance();
//        $mUsers->ClearSessions();
//        $this->user = $mUsers->Get();

        // Перенаправление на страницу авторизации, если это необходимо.
        if ($this->user == null && $this->needLogin)
        {
            header("Location: index.php?c=login");
            die();
        }

        // Засекаем время начала обработки запроса.
        $this->start_time = microtime(true);
    }

    //
    // Виртуальный генератор HTML.
    //
    protected function OnOutput()
    {
        // Основной шаблон всех страниц.
//        $vars = array('content' => $this->content);
//        $page = $this->View('tpl_main.php', $vars);

        // Время обработки запроса.
        $time = microtime(true) - $this->start_time;
//        $page .= "<!-- Время генерации страницы: $time сек.-->";

        // Вывод HTML.
//        echo $page;
    }
}
