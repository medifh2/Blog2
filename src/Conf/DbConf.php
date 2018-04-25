<?php

namespace Conf;

use PDO;
class DbConf
{

    static function getData()
    {
        $db_conf['name'] = 'Blog';
        $db_conf['host'] = '192.168.33.10';
        $db_conf['user'] = 'root';
        $db_conf['pass'] = 'root';
        $db_conf['charset'] = 'utf8';
        $dsn = "mysql:host = {$db_conf['host']}; db = {$db_conf['name']};
        charset = {$db_conf['charset']}";
        $opt =
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
        $pdo = new PDO($dsn, $db_conf['user'], $db_conf['pass'], $opt);
        return $pdo;
    }
    
    private function __construct()
    {

    }
    private static $_instance = null;

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

