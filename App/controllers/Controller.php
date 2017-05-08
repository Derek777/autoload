<?php
//
// Базовый класс контроллера.
//
abstract class Controller
{
    //
    // Конструктор.
    //
    function __construct()
    {
    }

    //
    // Полная обработка HTTP запроса.
    //
    public function Index()
    {
        $this->OnInput();
        $this->OnOutput();
    }

    //
    // Виртуальный обработчик запроса.
    //
    protected function OnInput()
    {
    }

    //
    // Виртуальный генератор HTML.
    //
    protected function OnOutput()
    {
    }

    //
    // Запрос произведен методом GET?
    //
    protected function IsGet()
    {
        return $_SERVER['REQUEST_METHOD'] == 'GET';
    }

    //
    // Запрос произведен методом POST?
    //
    protected function IsPost()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    //
    // Генерация HTML шаблона в строку.
    //
    protected function View($fileName, $vars = array())
    {
        $v = V_Main::Instance();
        $v->Render($fileName, $vars);
    }
}