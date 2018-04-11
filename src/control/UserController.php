<?php
namespace control;

use view\View;
use model\DbModel;
use model\ReaderModel;
use model\WriterModel;
use model\AdminModel;
use conf\DbConf;
class UserController {

    public function showLoginPage()
    {
        $view_gen = new View;
        $view_gen -> pageGenerate ('LogView.html');
    }

    public function showSettings()
    {
        $view_gen = new View;
        $view_gen -> pageGenerate ('UserpageSettingsView.html');
    }

    public function showRegPage()
    {
        $view_gen = new View;
        $view_gen -> pageGenerate ('RegView.html');
    }

    public function showUserPage()
    {
        $view_gen = new View;
        $view_gen -> pageGenerate ('UserpageView.html');
    }

    public function logout()
    {
        $_SESSION['is_login'] = 0;
        $vie_wgen = new View;
        $vie_wgen -> pageGenerate ('MainpageView.html');
    }

    public function login()
    {
        $view_gen = new View;
        $dbconf = new DbConf;
        $connect = new DbModel($dbconf);
        $login = $_POST["login"];
        $pass = md5($_POST["pass"]);
        if ($userdate = $connect -> loginUser($login, $pass))
        {
            switch ($userdate['accesslvl']) {
                case 'reader' : $user = new ReaderModel($userdate['Login'], $userdate['Password'], $userdate['Username'], $userdate['About_me']); break;
                case 'writer' : $user = new WriterModel($userdate['Login'], $userdate['Password'], $userdate['Username'], $userdate['About_me']); break;
                case 'admin' : $user = new AdminModel($userdate['Login'], $userdate['Password'], $userdate['Username'], $userdate['About_me']); break;
            }
            $_SESSION['is_login'] = 1;
            $_SESSION['Userdata'] = $user -> allData();
            $view_gen -> pageGenerate ('MainpageView.html');
        }
        else {
            echo "Wrong password or login";
            $view_gen -> pageGenerate ('LogView.html');
        }


    }
    public function registration()
    {
        $view_gen = new View;
        $dbconf = new DbConf;
        $connect = new DbModel($dbconf);

        $_POST["pass"] = str_replace(' ','',$_POST["pass"]);
        $_POST["r_pass"] = str_replace(' ','',$_POST["r_pass"]);
        $_POST["login"] = str_replace(' ','',$_POST["login"]);
        $_POST["username"] = str_replace(' ','',$_POST["username"]);
        $pass = $_POST["pass"];
        $r_pass = $_POST["r_pass"];
        if (!$pass || !$_POST["login"] || !$_POST["username"] || ($pass !== $r_pass))
        {
            $view_gen -> pageGenerate ('RegView.html');
            die ("incorrect data!");
        }
        $pass = md5($pass);
        $user =
            [
                'login' => $_POST["login"],
                'pass' =>$pass,
                'username' => $_POST["username"],
                'about_me' => $_POST["about_me"],
                'lvl' => 'reader'
            ];
        if ($connect -> addUser($user))
        {
            $user = new ReaderModel($user['login'], $user['pass'], $user['username'], $user['about_me']);
            $_SESSION['is_login'] = 1;
            $_SESSION['Userdata'] = $user -> allData();
            $view_gen -> pageGenerate ('MainpageView.html');
        }
        else {
            $view_gen -> pageGenerate ('RegView.html');
            die ("A User with such data is already registered!");
        }
    }
    public function editUserData()
    {
        $view_gen = new View;
        $dbconf = new DbConf;
        $connect = new DbModel($dbconf);

        $_POST["n_pass"] = str_replace(' ','',$_POST["n_pass"]);
        $_POST["n_username"] = str_replace(' ','',$_POST["n_username"]);
        if (isset($_POST["n_pass"]))
        {
            $pass = $_POST["n_pass"];
            $pass = md5($pass);
        }
        $user =
            [
                'login' => $_SESSION['Userdata']['Login'],
                'pass' => $pass,
                'username' => $_POST["n_username"],
                'about_me' => $_POST["n_about"],
            ];
        if ($user["username"])
        $connect -> editUser($user);

        if ($_POST["n_username"]) $_SESSION['Userdata']["Username"] = $_POST["n_username"];
        if ($_POST["n_about"]) $_SESSION['Userdata']["About_me"] = $_POST["n_about"];
        $view_gen -> pageGenerate ('UserpageView.html');
    }
}
