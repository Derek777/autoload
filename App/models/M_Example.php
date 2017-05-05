<?php
//include_once('MSQL.php');
//include_once('M_Users.php');

//
// Менеджер для примера
//
class M_Example
{
    private static $instance; 	// ссылка на экземпляр класса
    private $msql; 				// драйвер БД
    private $mUsers;            // менеджер пользователей

    //
    // Получение единственного экземпляра (одиночка)
    //
    public static function Instance()
    {
        if (self::$instance == null)
            self::$instance = new M_Example();

        return self::$instance;
    }

    //
    // Конструктор
    //
    public function __construct()
    {
        $this->msql   = MSQL::Instance();
        $this->mUsers = M_Users::Instance();
    }

    //
    // Некая функция для всех.
    //
    public function MakeMagic($text)
    {
        return strtolower($text);
    }

    //
    // А эта функция доступна тем, у кого есть привилегия USE_SECRET_FUNCTIONS.
    //
    public function MakeSecretMagic($text)
    {
        if (!$this->mUsers->Can('USE_SECRET_FUNCTIONS'))
            return null;

        return strtoupper($text);
    }
}
