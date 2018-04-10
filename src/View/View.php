<?php
namespace View;

class View
{
    static function pageGenerate ($file)
    {
            if ($_SESSION['is_login']) {
                include 'UtopView.php';
            }
        else include 'TopView.php';
        include $file.".php";
    }
    private static $_instance = null;
    private function __construct() {

    }
    protected function __clone() {

    }
    static public function getInstance() {
        if(is_null(self::$_instance))
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}