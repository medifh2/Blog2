<?php

namespace Conf;

class DbConf
{
    private $db_conf;

    function __construct()
{
        $this -> db_conf['name'] = 'Blog';
        $this -> db_conf['host'] = '192.168.33.10';
        $this -> db_conf['user'] = 'root';
        $this -> db_conf['pass'] = 'root';
        $this -> db_conf['charset'] = 'utf8';
}
    function getData()
    {
        return $this -> db_conf;
    }
}

