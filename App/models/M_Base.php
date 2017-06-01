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

//    public function get(){
//        $result = mysqli_query($this->link, "SELECT login FROM users ");
//        printf("Select returned %d rows.\n", mysqli_num_rows($result));
//        print_r($result);
//    }

    public function Select($query)
    {
        $result = mysqli_query($this->link, $query);

        if (!$result)
            die(mysqli_error($this->link));

        $n = mysqli_num_rows($result);
        $arr = array();

        for($i = 0; $i < $n; $i++)
        {
            $row = mysqli_fetch_assoc($result);
            $arr[] = $row;
        }

        return $arr;
    }

    public function Delete($table, $where)
    {
        $query = "DELETE FROM $table WHERE $where";
        $result = mysqli_query($this->link, $query);

        if (!$result)
            die(mysqli_error_list ($this->link));

        return mysqli_affected_rows($this->link);
    }

    public function Update($table, $object, $where)
    {
        $sets = array();

        foreach ($object as $key => $value)
        {
            $key = mysqli_real_escape_string($this->link, $key . '');

            if ($value === null)
            {
                $sets[] = "$key=NULL";
            }
            else
            {
                $value = mysqli_real_escape_string($this->link, $value . '');
                $sets[] = "$key='$value'";
            }
        }

        $sets_s = implode(',', $sets);
        $query = "UPDATE $table SET $sets_s WHERE $where";
        $result = mysqli_query($this->link, $query);

        if (!$result)
            die(mysqli_error_list ($this->link));

        return mysqli_affected_rows($this->link);
    }

    public function Insert($table, $object)
    {
        $columns = array();
        $values = array();

        foreach ($object as $key => $value)
        {
            $key = mysqli_real_escape_string($this->link, $key . '');
            $columns[] = $key;

            if ($value === null)
            {
                $values[] = 'NULL';
            }
            else
            {
                $value = mysqli_real_escape_string($this->link, $value . '');
                $values[] = "'$value'";
            }
        }

        $columns_s = implode(',', $columns);
        $values_s = implode(',', $values);

        $query = "INSERT INTO $table ($columns_s) VALUES ($values_s)";
        $result = mysqli_query($this->link, $query);

        if (!$result)
            die(mysqli_error_list ($this->link));

        return mysqli_insert_id($this->link);
    }

}