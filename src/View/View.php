<?php
namespace View;
use Conf\LogoInfo;
class View
{
    static function pageGenerate ($file, $data_for_view = NULL)
    {
        $logo_info = new LogoInfo;
        $data_for_view['logo'] = $logo_info -> getData();
        if (isset($_SESSION['user_id']))
        {
            include 'UtopView.php';
        }
        else include 'TopView.php';

        include $file.".php";
    }

    private static $_instance = null;

    private function __construct()
    {

    }
    protected function __clone()
    {

    }

    static public function getInstance()
    {
        if(is_null(self::$_instance))
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

}