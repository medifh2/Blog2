<?php
namespace Control;

use View\View;
class MainPageController {

    function __construct()
    {

    }
    public function showMainPage()
    {
        View::pageGenerate ('MainpageView');
    }
}
// ROUTER in index.php
// autoload !!! (PSR)
// PDO
// MVC
// OOP in PHP
// --ORM in PHP - read about
//namespace csr
