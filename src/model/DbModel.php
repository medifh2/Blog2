<?php
namespace model;

use PDO;
use conf\Dbconf;
class DbModel
{
    private $dsn, $opt, $pdo;

    function __construct($db_conf)
    {
        $db_conf = $db_conf -> getData();
        $this -> dsn = "mysql:host = {$db_conf['host']}; db = {$db_conf['name']}; 
        charset = {$db_conf['charset']}";
        $this -> opt =
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this -> pdo = new PDO($this -> dsn, $db_conf['user'], $db_conf['pass'], $this -> opt);
    }

    function addUser($user)
    {
        if (!($this -> pdo)) echo "error";
        $st_check = ($this -> pdo) -> prepare ('SELECT Login FROM blog.Users WHERE ((Login = :login) OR (Username = :username))');
        $st_check -> bindParam(':login', $user['login']);
        $st_check -> bindParam(':username', $user['username']);
        $st_check -> execute();
        $res = $st_check -> fetchAll();
        if ($res) return 0;
        else {
            $st_insert = ($this->pdo)->prepare("INSERT INTO blog.Users 
            (Login, Password, Username, About_me, accesslvl) 
            VALUES (:login, :pass, :uname, :about, :lvl)");
            $st_insert->bindParam(':uname', $user['username']);
            $st_insert->bindParam(':login', $user['login']);
            $st_insert->bindParam(':pass', $user['pass']);
            $st_insert->bindParam(':about', $user['about_me']);
            $st_insert->bindParam(':lvl', $user['lvl']);
            $st_insert->execute();
            return 1;
        }
    }

    function loginUser($login, $pass)
    {
        $st = ($this -> pdo) -> prepare ('SELECT * FROM blog.Users WHERE ((Login = :login) AND (Password = :pass))');
        $st -> bindParam(':login', $login);
        $st -> bindParam(':pass', $pass);
        $st -> execute();
        $res = $st -> fetchAll();
        $res = $res[0];
        return $res;
    }
    function editUser($user)
    {
        if ($user['username'])
        {
            $st_name = ($this->pdo)->prepare("UPDATE blog.Users SET Username=:username WHERE Login=:login");
            $st_name->bindParam(':login', $user['login']);
            $st_name->bindParam(':username', $user['username']);
            $st_name->execute();
        }
        if ($user['pass'])
        {
            $st_pass = ($this->pdo)->prepare("UPDATE blog.Users SET Password=:pass WHERE Login=:login");
            $st_pass->bindParam(':login', $user['login']);
            $st_pass->bindParam(':pass', $user['pass']);
            $st_pass->execute();
        }
        if ($user['about_me'])
        {
            $st_about = ($this->pdo)->prepare("UPDATE blog.Users SET About_me=:about_me WHERE Login=:login");
            $st_about->bindParam(':login', $user['login']);
            $st_about->bindParam(':about_me', $user['about_me']);
            $st_about->execute();
        }
    }
}