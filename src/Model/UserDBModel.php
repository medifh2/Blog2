<?php
namespace Model;

class UserDBModel extends DBModel
{

    function addUser($user)
    {
        if (!($this -> pdo)) return false;
        $pdo = $this -> pdo;
        $st_check = $pdo -> prepare ('SELECT Login FROM Blog.users WHERE ((Login = :login) OR (Username = :username))');
        $st_check -> bindParam(':login', $user['login']);
        $st_check -> bindParam(':username', $user['username']);
        $st_check -> execute();
        $res = $st_check -> fetchAll();
        if ($res) return false;
        else {
            $st_insert = $pdo->prepare("INSERT INTO Blog.users 
            (Login, Password, Username, About_me, Accesslvl, RegDate, UserConfigs ) 
            VALUES (:login, :pass, :uname, :about, :lvl, :regdate, :userconfigs)");
            $st_insert->bindParam(':uname', $user['username']);
            $st_insert->bindParam(':login', $user['login']);
            $st_insert->bindParam(':pass', $user['pass']);
            $st_insert->bindParam(':about', $user['about_me']);
            $st_insert->bindParam(':lvl', $user['lvl']);
            $st_insert->bindParam(':regdate', $user['regdate']);
            $st_insert->bindParam(':userconfigs', $user['userconfigs']);
            $st_insert->execute();
            return true;
        }
    }

    function loginUser($login, $pass)
    {
        $pdo = $this -> pdo;
        $st = $pdo -> prepare ('SELECT * FROM Blog.users WHERE ((Login = :login) AND (Password = :pass))');
        $st -> bindParam(':login', $login);
        $st -> bindParam(':pass', $pass);
        $st -> execute();
        $res = $st -> fetchAll();
        if ($res) $res = $res[0];
        return $res;
    }
    function editUser($user)
    {
        $pdo = $this -> pdo;
        if ($user['username'])
        {
            $st_name = $pdo -> prepare("UPDATE Blog.users SET Username=:username WHERE Login=:login");
            $st_name->bindParam(':login', $user['login']);
            $st_name->bindParam(':username', $user['username']);
            $st_name->execute();
        }
        if ($user['pass'])
        {
            $st_pass = $pdo -> prepare("UPDATE Blog.users SET Password=:pass WHERE Login=:login");
            $st_pass->bindParam(':login', $user['login']);
            $st_pass->bindParam(':pass', $user['pass']);
            $st_pass->execute();
        }
        if ($user['about_me'])
        {
            $st_about = $pdo -> prepare("UPDATE Blog.users SET About_me=:about_me WHERE Login=:login");
            $st_about->bindParam(':login', $user['login']);
            $st_about->bindParam(':about_me', $user['about_me']);
            $st_about->execute();
        }
    }
}