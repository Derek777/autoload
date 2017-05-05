<?php
//
// Помощник работы с БД
//
class MSQL
{
    private static $instance; 	// ссылка на экземпляр класса

    //
    // Получение единственного экземпляра (одиночка)
    //
    public static function Instance()
    {
        if (self::$instance == null)
            self::$instance = new MSQL();

        return self::$instance;
    }

    //
    // Выборка строк
    // $query    	- полный текст SQL запроса
    // результат	- массив выбранных объектов
    //
    public function Select($link ,$query)
    {
        $result = mysqli_query($link, $query);

        if (!$result)
            die(mysqli_error_list ($link));

        $n = mysqli_num_rows($result);
        $arr = array();

        for($i = 0; $i < $n; $i++)
        {
            $row = mysqli_fetch_assoc($result);
            $arr[] = $row;
        }

        return $arr;
    }

    //
    // Вставка строки
    // $table 		- имя таблицы
    // $object 		- ассоциативный массив с парами вида "имя столбца - значение"
    // результат	- идентификатор новой строки
    //
    public function Insert($link, $table, $object)
    {
        $columns = array();
        $values = array();

        foreach ($object as $key => $value)
        {
            $key = mysqli_real_escape_string($link, $key . '');
            $columns[] = $key;

            if ($value === null)
            {
                $values[] = 'NULL';
            }
            else
            {
                $value = mysqli_real_escape_string($link, $value . '');
                $values[] = "'$value'";
            }
        }

        $columns_s = implode(',', $columns);
        $values_s = implode(',', $values);

        $query = "INSERT INTO $table ($columns_s) VALUES ($values_s)";
        $result = mysqli_query($link, $query);

        if (!$result)
            die(mysqli_error_list ($link));

        return mysqli_insert_id($link);
    }

    //
    // Изменение строк
    // $table 		- имя таблицы
    // $object 		- ассоциативный массив с парами вида "имя столбца - значение"
    // $where		- условие (часть SQL запроса)
    // результат	- число измененных строк
    //
    public function Update($link, $table, $object, $where)
    {
        $sets = array();

        foreach ($object as $key => $value)
        {
            $key = mysqli_real_escape_string($link, $key . '');

            if ($value === null)
            {
                $sets[] = "$key=NULL";
            }
            else
            {
                $value = mysqli_real_escape_string($link, $value . '');
                $sets[] = "$key='$value'";
            }
        }

        $sets_s = implode(',', $sets);
        $query = "UPDATE $table SET $sets_s WHERE $where";
        $result = mysqli_query($link, $query);

        if (!$result)
            die(mysqli_error_list ($link));

        return mysqli_affected_rows($link);
    }

    //
    // Удаление строк
    // $table 		- имя таблицы
    // $where		- условие (часть SQL запроса)
    // результат	- число удаленных строк
    //
    public function Delete($link, $table, $where)
    {
        $query = "DELETE FROM $table WHERE $where";
        $result = mysqli_query($link, $query);

        if (!$result)
            die(mysqli_error_list ($link));

        return mysqli_affected_rows($link);
    }
}
