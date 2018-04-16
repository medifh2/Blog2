<?php
namespace Control;

use View\View;
use Model\UserDBModel;
use Model\ReaderModel;
use Model\WriterModel;
use Model\AdminModel;

class UserController extends Controller
{

    public function showLoginPage()
    {
        View:: pageGenerate ('LogView');
    }

    public function showSettings()
    {
        View:: pageGenerate ('UserProfileSettingsView');
    }

    public function showRegPage()
    {
        View:: pageGenerate ('RegView');
    }

    public function showUserProfile()
    {
        View:: pageGenerate ('UserProfileView');
    }

    public function logout()
    {
        $_SESSION['is_login'] = false;
        unset($_SESSION['Userdata']);
        unset($_SESSION['Userposts']);
        View::pageGenerate ('MainpageView');
    }

    public function login()
    {
        $connect = new UserDBModel;
        $login = $_POST["login"];
        $pass = ($_POST["pass"]);
        if ($userdata = $connect -> loginUser($login, $pass))
        {
            switch ($userdata['Accesslvl']) {
                case 'reader' : $user = new ReaderModel($userdata['Login'], $userdata['Password'], $userdata['Username'], $userdata['About_me']); break;
                case 'writer' : $user = new WriterModel($userdata['Login'], $userdata['Password'], $userdata['Username'], $userdata['About_me']); break;
                case 'admin' : $user = new AdminModel($userdata['Login'], $userdata['Password'], $userdata['Username'], $userdata['About_me']); break;
            }
            $_SESSION['is_login'] = 1;
            $_SESSION['Userdata'] = $user -> allData();
            $_SESSION['message'] = "Hello, ".$_SESSION['Userdata']['Username'];
            View::pageGenerate ('MainpageView');
        }
        else
            {
                $_SESSION['error_message'] = 'Wrong password or login';
                View::pageGenerate ('LogView');
            }


    }
    public function registration()
    {
        $connect = new UserDBModel;

        $_POST["pass"] = str_replace(' ','',$_POST["pass"]);
        $_POST["r_pass"] = str_replace(' ','',$_POST["r_pass"]);
        $_POST["login"] = str_replace(' ','',$_POST["login"]);
        $_POST["username"] = str_replace(' ','',$_POST["username"]);
        $pass = $_POST["pass"];
        $r_pass = $_POST["r_pass"];
        if (!$pass || !$_POST["login"] || !$_POST["username"] || ($pass !== $r_pass))
        {
            $_SESSION['error_message'] = 'Incorrect data!' ;
            View::pageGenerate ('RegView');
            return;
        }
        $user =
            [
                'login' => $_POST["login"],
                'pass' =>$pass,
                'username' => $_POST["username"],
                'about_me' => '',
                'lvl' => 'reader',
                'regdate' => date('jS \of F Y'),
                'userconfigs' => ''
            ];
        if ($connect -> addUser($user))
        {
            $user = new ReaderModel($user['login'], $user['pass'], $user['username'], $user['about_me']);
            $_SESSION['is_login'] = 1;
            $_SESSION['Userdata'] = $user -> allData();
            View::pageGenerate ('MainpageView');
        }
        else {
            $_SESSION['error_message'] = 'A User with such data is already registered!' ;
            View::pageGenerate ('RegView');
            return;
        }
    }
    public function editUserData()
    {
        $connect = new UserDBModel;

        $_POST["n_pass"] = str_replace(' ','',$_POST["n_pass"]);
        $_POST["n_username"] = str_replace(' ','',$_POST["n_username"]);
        if (isset($_POST["n_pass"]))
        {
            $pass = $_POST["n_pass"];
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
        $_SESSION['message'] = "Updates saved";
        View::pageGenerate ('UserProfileView');

    }
}
