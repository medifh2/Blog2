<?php

namespace Conf;

class LogoInfo
{
    private $logo;

    function __construct()
    {
        $this -> logo = '2.png';

    }
    function getData()
    {
        return $this -> logo;
    }
}

