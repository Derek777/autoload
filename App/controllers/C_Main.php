<?php


class C_Main extends V_Generator
{
    private $input = 55555;		// текст для преобразования
    private $result = 'INPUT!!!!!!!!';

    public function __construct()
    {
//        parent::__construct();
    }

    public function index(){
        echo "connect...";
//        $fff = new M_User();
//        $page = new V_Render();
//        $fff->hoho();
//        $page->start();
        $this->OnOutput();

    }

    protected function OnOutput(){
//        $mUsers = M_Users::Instance();
//        $text = "content site";
////        $root_path = './App';
//        $tmp = new VTemplate();
//        $tmp -> set_file('rrr');
//        $tmp -> set_vars(array(
//            'TITLE' => 'My site',
//            'TEXT' => $text));
//        $tmp -> display();

//        require "../views/rrr.tpl"
        // Генерация содержимого страницы Welcome.
//        $vars = array(
//            'input' => $this->input,
//            'result' => $this->result,
//            'canUseSecretFunctions' => $mUsers->Can('USE_SECRET_FUNCTIONS'));

//        $this->content = $this->View('www.php', $vars);
        $page = new V_Render();
        $viev = new View();
//        $this->get_tpl('rrr.tpl');
//        $this->set_tpl('{TITLE}', 'Super');
////        $this->set_tpl("{title}", "Super");
//        $this->set_tpl('{content}', 'GGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGG');
//        $this->tpl_parse();
//        echo $this->template;
//        $page = V_Main::Instance();
//
        $arr = [11, 22, 33, 44, 55];
        $viev->generate($arr,"rrr.tpl");

////        $page->start("rrr");
//        $page->get_tpl("rrr");
//        $page->set_tpl('{TITLE}', 'Super');
//        $page->set_tpl('{TEXT}', 'GGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGG');
////        $page-$this->set_tpl('{ARR}', $arr);
//        $page->tpl_parse();
//        print $page->template;

        // C_Base.
//        parent::OnOutput();

    }
}
