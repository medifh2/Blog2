<?php
namespace Control;

use View\View;
use Model\UserDBModel;
use Model\ReaderModel;
use Model\WriterModel;
use Model\AdminModel;

class UserController extends Controller
{

    public function showSettings()
    {
        if (!$_SESSION['is_login']) {
            View::pageGenerate('Error404View');
            return;
        }
        View:: pageGenerate ('UserProfileSettingsView');
    }

    public function showUserProfile()
    {
        if (!$_SESSION['is_login']) {
            View::pageGenerate('Error404View');
            return;
        }
        View:: pageGenerate ('UserProfileView');
    }
    
    public function showOtherUserProfile()
    {
        View:: pageGenerate ('OtherUserProfileView');
    }

    public function logout()
    {
        $_SESSION['is_login'] = false;
        unset($_SESSION['Userdata']);
        header('Location: http://192.168.33.10/');
    }

    public function login()
    {
        if (!isset($_POST['pass']))
        {
            View:: pageGenerate ('LogView');
            return;
        }
        if ($_SESSION['is_login'])
        {
            View::pageGenerate('Error404View');
            return;
        }
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
            header('Location: http://192.168.33.10/');
        }
        else
            {
                $error_message = 'Wrong password or login';
                $data_for_view['error_message'] = $error_message;
                View:: pageGenerate ('LogView', $data_for_view);
            }

    }

    public function registration()
    {
        if (!isset($_POST['pass']))
        {
            View:: pageGenerate ('RegView');
            return;
        }
        if ($_SESSION['is_login'])
        {
            View::pageGenerate('Error404View');
            return;
        }

        $connect = new UserDBModel;

        $_POST["pass"] = str_replace(' ','',$_POST["pass"]);
        $_POST["r_pass"] = str_replace(' ','',$_POST["r_pass"]);
        $_POST["login"] = str_replace(' ','',$_POST["login"]);
        $_POST["username"] = str_replace(' ','',$_POST["username"]);
        $pass = $_POST["pass"];
        $r_pass = $_POST["r_pass"];
        if (!$pass || !$_POST["login"] || !$_POST["username"] || ($pass !== $r_pass))
        {
            $date_for_view['error_message'] = 'Incorrect data!' ;
            View:: pageGenerate ('RegView', $date_for_view);
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
            header('Location: http://192.168.33.10/');
        }
        else {
            $date_for_view['error_message'] = 'A User with such data is already registered!' ;
            View:: pageGenerate ('RegView', $date_for_view);
            return;
        }
    }

    public function editUserData()
    {
        if (!$_SESSION['is_login'])
        {
            View::pageGenerate('Error404View');
            return;
        }
        $connect = new UserDBModel;
        $_POST["n_pass"] = str_replace(' ','',$_POST["n_pass"]);
        $_POST["c_pass"] = str_replace(' ','',$_POST["c_pass"]);
        $_POST["n_username"] = str_replace(' ','',$_POST["n_username"]);
        if (isset($_POST["n_pass"]))
        {
            $pass = $_POST["n_pass"];
        }
        $user =
            [
                'login' => $_SESSION['Userdata']['Login'],
                'pass' => $_POST["n_pass"],
                'c_pass' => $_POST["c_pass"],
                'username' => $_POST["n_username"],
                'about_me' => $_POST["n_about"],
            ];
        if ($connect -> editUser($user))
        {
            if ($_POST["n_username"]) $_SESSION['Userdata']["Username"] = $_POST["n_username"];
            if ($_POST["n_about"]) $_SESSION['Userdata']["About_me"] = $_POST["n_about"];
            header('Location: http://192.168.33.10/profile');
        }
        else
            {
                $error_message = "Wrong password";
                $data_for_view['error_message'] = $error_message;
                View:: pageGenerate ('LogView', $data_for_view);
            }
    }
}
