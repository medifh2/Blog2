<?php
namespace control;

use view\View;
class MainPageController {

    function __construct()
    {

    }
    public function showMainPage()
    {
        $view_gen = new View;
        $view_gen -> pageGenerate ('MainpageView.html');
    }
}
// ROUTER in index.php
// autoload !!! (PSR)
// PDO
// MVC
// OOP in PHP
// --ORM in PHP - read about
//namespace csr
