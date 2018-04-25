<?php
namespace Model;

use Conf\DbConf;
class DBModel extends Model
{
    protected $pdo;

    function __construct()
    {
        DbConf::getInstance();
        $this -> pdo = DbConf:: getData();
    }
}