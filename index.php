<?php

    session_start();
    if (!isset($_SESSION['error_message'])) $_SESSION['error_message'] = 0;
    if (!isset($_SESSION['Numposts'])) $_SESSION['Numposts'] = 0;
    require_once 'loader.php';

    use View\View;
    use Tec\Router;

    View::getInstance();
    $router = new Router;
