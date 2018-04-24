<?php
namespace Model;

class UserDBModel extends DBModel
{

    function addUser($user)
    {
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

    function getForQuery($query)
    {
        $pdo = $this -> pdo;
        $statement = "SELECT * FROM Blog.users  WHERE (Username LIKE '%".$query."%') OR (Login LIKE '%".$query."%')";
        $st = $pdo -> prepare ($statement);
        $st -> bindParam(':query', $query);
        $st -> execute();
        $res = $st -> fetchAll();
        return $res;
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
    
    function getFromToUsers($from, $to)
    {
        $pdo = $this -> pdo;
        $st = $pdo -> prepare ('SELECT * FROM Blog.users ORDER BY Login LIMIT :from, :to ');
        $st -> bindParam(':from', $from);
        $st -> bindParam(':to', $to);
        $st -> execute();
        $res = $st -> fetchAll();
        return $res;
    }
    
    function getInfoForName($username)
    {
        $pdo = $this -> pdo;
        $st = $pdo -> prepare ('SELECT Login, Username, About_me, Accesslvl, RegDate, UserConfigs FROM Blog.users WHERE (Username = :username)');
        $st -> bindParam(':username', $username);
        $st -> execute();
        $res = $st -> fetchAll();
        return $res;
    }

    function getForID($id)
    {
        $pdo = $this -> pdo;
        $st = $pdo -> prepare ('SELECT Login, Username, About_me, Accesslvl, RegDate, UserConfigs FROM Blog.users WHERE (ID = :id)');
        $st -> bindParam(':id', $id);
        $st -> execute();
        $res = $st -> fetchAll();
        return $res[0];
    }

    function editUser($user)
    {
        $pdo = $this -> pdo;
        $st_check = $pdo -> prepare("SELECT * FROM Blog.users WHERE Login=:login");
        $st_check->bindParam(':login', $user['login']);
        $st_check->execute();
        $res = $st_check -> fetchAll();
        if ($res[0]['Password'] !== $user['c_pass']) return false;
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
        return true;
    }

}