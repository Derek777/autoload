<?php


class V_Main
{
    private static $instance; 	// ссылка на экземпляр класса
    public $content = 555555;

    //
    // Получение единственного экземпляра (одиночка)
    //
    public static function Instance()
    {
        if (self::$instance == null)
            self::$instance = new V_Main();

        return self::$instance;
    }
    public function Render($fileName, $vars = array()){

        $vars = array('content' => $this->content);
        foreach ($vars as $k => $v)
            $$k = $v;
//        $this->content = $fileName;


        ob_start();
        $page = file_get_contents($fileName);
        echo $page;

// Получаем содержимое буфера в переменную:
        $content = ob_get_contents();
// Чистим бфер
        ob_end_clean();
// Пишем данные в файл:
        echo $content;
//        include "tpl_main.php";
//        return ob_get_clean();
    }
}