<?php
namespace Model;

use PDO;
use Conf\DbConf;
class DBModel extends Model
{
    protected $pdo;

    function __construct()
    {
        $db_conf = new DbConf;
        $db_conf = $db_conf -> getData();
        $dsn = "mysql:host = {$db_conf['host']}; db = {$db_conf['name']};
        charset = {$db_conf['charset']}";
        $opt =
                [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                ];
        $this -> pdo = new PDO($dsn, $db_conf['user'], $db_conf['pass'], $opt);
    }
}