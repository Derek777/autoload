<?php
class V_Generator
{
    var $vars     = array();
    var $template;

    function get_tpl($tpl_name)
    {


        if(empty($tpl_name))
        {
            echo "11";
            return false;
        }
        else
        {
            $this->template  = file_get_contents("views\\rrr.tpl");
        }
        return "huyuyuyuy";

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
}
//$parse = new parse_class;

?>