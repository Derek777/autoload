<?php


class M_Base
{
    protected $link;
    private static $instance;

    public static function Instance()
    {
        if (self::$instance == null)
            self::$instance = new M_Base();

        return self::$instance;
    }

    public function __construct()
    {
        $this->link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME)
        or die(mysqli_error_list($this->link));
    }

    public function get(){
        $result = mysqli_query($this->link, "SELECT login FROM users ");
        printf("Select returned %d rows.\n", mysqli_num_rows($result));
        print_r($result);
    }

}