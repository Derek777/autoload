<?php


class VTemplate
{
    var $file = ""; //для хранения имени файла шаблона
    var $blocks = array();
    var $vars = array(); //для хранения переменных шаблона
    var $compiled = ""; //результат компиляции шаблона

    // Установка файла шаблона
    function set_file($fname)
    {
        //переменная root_path объявляется перед подключением шаблона
        global $root_path; //корень сайта
        $file = $root_path.'App/views/'.$fname.'.tpl'; //имя файла шаблона
        //проверка существования шаблона и права на чтения
        if(is_file($file) && is_readable($file))
        {
            $this->file = $file;
            return;
        }
        die('<b>Fatal Error:</b> не могу открыть файл шаблона '.$file);
    }

    //Установка основных переменных
    function set_vars($vars)
    {
        foreach($vars as $var => $val)
        {
            //Просто заносим в массив для последующей обработки
            $this->vars["{{$var}}"] = $val;
        }
    }

    //Установка блочных переменных
    function set_block_vars($block, $vars)
    {
        //обрабатываем имя блока и устанавливаем переменные
        $block_arr = explode('.',$block);
        $c = &$this->blocks;
        $last = $block_arr[sizeof($block_arr)-1];
        foreach($block_arr as $r)
        {
            if(!isset($c['#blocks'][$r]) && $r != $last)
            {
                return false;
            }
            else if($r == $last)
            {
                $c['#blocks'][$r][] = array(
                    '#vars'	=> array(),
                    '#blocks'	=> array(),
                );
            }
            $c = &$c['#blocks'][$r][sizeof($c['#blocks'][$r])-1];
        }
        //Полученные переменные заносим в массив
        foreach($vars as $var => $val)
        {
            $c['#vars']["{{$var}}"] = $val;
        }
    }

    //Загрузка шаблона
    function load_file($file)
    {
        global $root_path;
        $c = file_get_contents($file); //загрузка файла в переменную
        $matches = array();
        //Поиск подключения внешних файлов шаблона
        preg_match_all('#<!-- INCLUDE ([^>]+) -->#', $c, $matches, PREG_SET_ORDER);
        $f = $r = array();
        //Если есть такие то загружаем
        foreach($matches as $inc)
        {
            if(!is_file($root_path."template/{$inc[1]}.tpl") || !is_readable($root_path."/template/{$inc[1]}.tpl"))
            {
                continue;
            }
            $f[] = $inc[0];
            $r[] = $this->load_file($root_path."template/{$inc[1]}.tpl");
        }
        $c = str_replace($f, $r, $c);
        return $c;
    }

    //Вывод резултата
    function display()
    {
        $this->compile(); //компилируем
        eval($this->compiled); //и выводим
    }

    // Компилирование шаблона
    function compile()
    {
        $c = $this->load_file($this->file); // загружаем файл шаблона с подфайлами
        // заменяем все определенные переменные в шаблоне
        $c = str_replace(array_keys($this->vars), array_values($this->vars), $c);
        $matches = array();
        //Поиск блоков в шаблоне
        preg_match_all('#<!-- BEGIN ([a-zA-Z._]+) -->#', $c, $matches, PREG_SET_ORDER);
        $indexes = array();
        $loops = array();
        $i = 0;
        //Обработка найденных блоков
        foreach($matches as $match)
        {
            $indexes[$match[1]] = "\$i_$i";
            $blocks = explode('.', $match[1]);
            $loop = "<?php for({$indexes[$match[1]]} = 0; {$indexes[$match[1]]} < sizeof(\$this->blocks['#blocks']['$blocks[0]']";
            for($j = 1; $j < sizeof($blocks); $j++)
            {
                $in = implode('.', array_slice($blocks, 0, $j));
                $loop .= "[{$indexes[$in]}]['#blocks']['{$blocks[$j]}']";
            }
            $loop .= "); {$indexes[$match[1]]}++){ ?>";
            $loops[$match[0]] = $loop;
            $i++;
        }
        //замена переменных в блоках
        $c = str_replace(array_keys($loops), array_values($loops), $c);
        $c = str_replace('<!-- END -->', '<?php } ?>', $c);

        //поиск переменных {}
        $matches = array();
        $vars = array();
        preg_match_all('#{([A-Za-z_]+\.[A-Za-z_.]+)}#', $c, $matches, PREG_SET_ORDER);
        foreach($matches as $match)
        {
            $blocks = explode('.', $match[1]);
            $var = "<?=(\$this->blocks";
            for($j = 0; $j < sizeof($blocks)-1; $j++)
            {
                $in = implode('.', array_slice($blocks, 0, $j+1));
                $var .= "['#blocks']['{$blocks[$j]}'][{$indexes[$in]}]";
            }
            $var .= "['#vars']['{{$blocks[$j]}}']) ?>";
            $vars[$match[0]] = $var;
            $i++;
        }

        $c = str_replace(array_keys($vars), array_values($vars), $c);
        $this->compiled = '?>'.$c;
    }
}