<?php
namespace Control;

use View\View;
use Model\DbModel;
use Model\ReaderModel;
use Model\WriterModel;
use Model\AdminModel;

class UserController {

    public function showLoginPage()
    {
        View:: pageGenerate ('LogView');
    }

    public function showSettings()
    {
        View:: pageGenerate ('UserpageSettingsView');
    }

    public function showRegPage()
    {
        View:: pageGenerate ('RegView');
    }

    public function showUserPage()
    {
        View:: pageGenerate ('UserpageView');
    }

    public function logout()
    {
        $_SESSION['is_login'] = 0;
        View::pageGenerate ('MainpageView');
    }

    public function login()
    {
        $connect = new DbModel;
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
            View::pageGenerate ('MainpageView');
        }
        else {
            echo "Wrong password or login";
            View::pageGenerate ('LogView');
        }


    }
    public function registration()
    {
        $connect = new DbModel;

        $_POST["pass"] = str_replace(' ','',$_POST["pass"]);
        $_POST["r_pass"] = str_replace(' ','',$_POST["r_pass"]);
        $_POST["login"] = str_replace(' ','',$_POST["login"]);
        $_POST["username"] = str_replace(' ','',$_POST["username"]);
        $pass = $_POST["pass"];
        $r_pass = $_POST["r_pass"];
        if (!$pass || !$_POST["login"] || !$_POST["username"] || ($pass !== $r_pass))
        {
            View::pageGenerate ('RegView');
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
            View::pageGenerate ('MainpageView');
        }
        else {
            View::pageGenerate ('RegView');
            die ("A User with such data is already registered!");
        }
    }
    public function editUserData()
    {
        $connect = new DbModel;

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
        View::pageGenerate ('UserpageView');
    }
}
