<?php
namespace Control;

use Model\UserDBModel;
use Model\UserModel;

class UserController extends Controller
{

    public function showSettings()
    {
        if (!$_SESSION['is_login']) {
            $this -> showPage ('Error404View');
            return;
        }
        $this -> showPage ('UserProfileSettingsView');
    }

    public function showUserProfile()
    {
        if (!$_SESSION['is_login']) {
            $this -> showPage ('Error404View');
            return;
        }
        $this -> showPage ('UserProfileView');
    }
    
    public function showOtherUserProfile($user_id)
    {
        $connect = new UserDBModel;
        $user = $connect -> getForID($user_id);
        $user ['ID'] = $user_id;
        $data_for_view['other_user_data'] = $user;
        $this -> showPage ('OtherUserProfileView',$data_for_view);
    }

    public function logout()
    {
        $_SESSION['is_login'] = false;
        unset($_SESSION['userdata']);
        header('Location: http://192.168.33.10/');
    }

    public function login()
    {
        if (!isset($_POST['pass']))
        {
            $this -> showPage ('LogView');
            return;
        }

        if ($_SESSION['is_login'])
        {
            $this -> showPage('Error404View');
            return;
        }

        $connect = new UserDBModel;
        $login = $_POST["login"];
        $pass = md5($_POST["pass"]);
        if ($userdata = $connect -> loginUser($login, $pass))
        {
            $user = new UserModel($userdata['Login'], $userdata['Password'], $userdata['Username'], $userdata['About_me'], $userdata['Accesslvl'], $userdata['RegDate'], $userdata['Status']);
            print_r ($user -> allData());
            $_SESSION['is_login'] = 1;
            $_SESSION['userdata'] = $user -> allData();
            header('Location: http://192.168.33.10/');
        }
        else
            {
                $error_message = 'Wrong password or login';
                $data_for_view['error_message'] = $error_message;
                $this -> showPage ('LogView', $data_for_view);
            }

    }

    public function registration()
    {
        if (!isset($_POST['pass']))
        {
            $this -> showPage ('RegView');
            return;
        }
        if ($_SESSION['is_login'])
        {
            $this -> showPage ('Error404View');
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
            $this -> showPage ('RegView', $date_for_view);
            return;
        }
        $pass = md5($pass);
        $user =
            [
                'login' => $_POST["login"],
                'pass' =>$pass,
                'username' => $_POST["username"],
                'about_me' => '',
                'lvl' => 'reader',
                'reg_date' => date("y-m-d H:i:s "),
                'user_configs' => '',
                'status' => ''
            ];
        if ($connect -> addUser($user))
        {
            $user = new UserModel($user['login'], $user['pass'], $user['username'], $user['about_me'],'reader',$user['reg_date']);
            $_SESSION['is_login'] = 1;
            $_SESSION['userdata'] = $user -> allData();
            header('Location: http://192.168.33.10/');
        }
        else {
            $date_for_view['error_message'] = 'A User with such data is already registered!' ;
            $this -> showPage ('RegView', $date_for_view);
            return;
        }
    }

    public function editUserData()
    {
        if (!$_SESSION['is_login'])
        {
            $this -> showPage ('Error404View');
            return;
        }
        $connect = new UserDBModel;
        $_POST["n_pass"] = str_replace(' ','',$_POST["n_pass"]);
        $_POST["c_pass"] = str_replace(' ','',$_POST["c_pass"]);
        $_POST["n_username"] = str_replace(' ','',$_POST["n_username"]);
        if ($_POST["n_pass"])
        {
            $n_pass = md5($_POST["n_pass"]);
        }
        else $n_pass = false;
        $c_pass = md5($_POST["c_pass"]);
        $user =
            [
                'login' => $_SESSION['userdata']['login'],
                'pass' => $n_pass,
                'c_pass' => $c_pass,
                'username' => $_POST["n_username"],
                'about_me' => $_POST["n_about"],
            ];
        if ($connect -> editUser($user))
        {
            if ($_POST["n_username"]) $_SESSION['userdata']["username"] = $_POST["n_username"];
            if ($_POST["n_about"]) $_SESSION['userdata']["about_me"] = $_POST["n_about"];
            header('Location: http://192.168.33.10/profile');
        }
        else
            {
                $error_message = "Wrong password";
                $data_for_view['error_message'] = $error_message;
                $this -> showPage ('UserProfileSettingsView', $data_for_view);
            }
    }
}
