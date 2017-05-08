<?php


class V_Render
{
    var $vars     = array();
    var $template;


    function get_tpl($tpl_name)
    {
        if(false)
        {
            return false;
        }
        else
        {
            global $root_path;

            $this->template  = file_get_contents('App/views/'.$tpl_name.'.tpl');
        }
    }

    function set_tpl($key,$var)
    {
        $this->vars[$key] = $var;
    }

    function tpl_parse()
    {
        foreach($this->vars as $find => $replace)
        {
            $this->template = str_replace($find, $replace, $this->template);
        }
    }

     public function start($filename){
         global $root_path;
         echo $root_path;
         ob_start();
         readfile($root_path.'App/views/'.$filename.'.tpl');
         $content = ob_get_contents();
         ob_end_clean();
         echo $content;
     }
}