<?php
namespace Control;
use Model\UserDBModel;
class UserController extends Controller
{

    public function showSettings()
    {
        if (!isset($_SESSION['user_id'])) {
            $this -> showPage ('Error404View');
            return;
        }
        $data_for_view['user'] = $this -> getUserInfo(isset($_SESSION['user_id']));
        $this -> showPage ('UserProfileSettingsView', $data_for_view);
    }

    public function showUserProfile()
    {
        if (!isset($_SESSION['user_id'])) {
            $this -> showPage ('Error404View');
            return;
        }
        $data_for_view['user'] = $this -> getUserInfo($_SESSION['user_id']);
        $this -> showPage ('UserProfileView', $data_for_view);
    }
    
    public function showOtherUserProfile($user_id)
    {
        $connect = new UserDBModel;
        $user = $connect -> getForID($user_id);
        $data_for_view['other_user_data'] = $user;
        $data_for_view['user'] = $this -> getUserInfo(isset($_SESSION['user_id']));
        $this -> showPage ('OtherUserProfileView',$data_for_view);
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        $host  = $_SERVER['HTTP_HOST'];
        $route = 'Location: http://'.$host.'/';
        header($route);
    }

    public function login()
    {
        if (!isset($_POST['pass']))
        {
            $this -> showPage ('LogView');
            return;
        }

        if (isset($_SESSION['user_id']))
        {
            $this -> showPage('Error404View');
            return;
        }

        $connect = new UserDBModel;
        $login = $_POST["login"];
        $pass = md5($_POST["pass"]);
        if ($userdata = $connect -> loginUser($login, $pass))
        {
            //print_r ($user -> allData());
            $_SESSION['user_id'] = $userdata['ID'];
            $data_for_view['user'] = $this->getUserInfo($_SESSION['user_id']);
            $this -> showPage ('UserProfileView', $data_for_view);
        }
        else
            {
                $data_for_view['error_message'] = 'Wrong password or login';
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
        if (isset($_SESSION['user_id']))
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
                'status' => 'unban'
            ];
        if ($user['login'] = $connect -> addUser($user))
        {
            $_SESSION['user_id'] = $user['login'];
            $data_for_view['user'] = $this->getUserInfo($_SESSION['user_id']);
            $this -> showPage ('UserProfileView', $data_for_view);
        }
        else {
            $date_for_view['error_message'] = 'A User with such data is already registered!' ;
            $this -> showPage ('RegView', $date_for_view);
            return;
        }
    }

    public function editUserData()
    {
        if (!isset($_SESSION['user_id']))
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
                'login' => $this -> getUserInfo($_SESSION['user_id'])['Login'],
                'pass' => $n_pass,
                'c_pass' => $c_pass,
                'username' => $_POST["n_username"],
                'about_me' => $_POST["n_about"],
            ];
        if ($connect -> editUser($user))
        {
            $data_for_view['message'] = 'Changes were saved';
            $data_for_view['user'] = $this->getUserInfo($_SESSION['user_id']);
            $this -> showPage ('UserProfileView', $data_for_view);
        }
        else
            {
                $error_message = "Wrong password";
                $data_for_view['error_message'] = $error_message;
                $data_for_view['user'] = $this -> getUserInfo($_SESSION['user_id']);
                $this -> showPage ('UserProfileSettingsView', $data_for_view);
            }
    }

    public function showUsersTable()
    {
        $connect = new UserDBModel;
        $all_users = ($connect -> getFromToUsers(0, 10));
        $data_for_view ['all_users'] = $all_users;
        $this -> showPage ('UserTableView', $data_for_view);
    }

    public function editOtherUserDataShow($user_ID)
    {
        if (!isset($_SESSION['user_id']))
        {
            $this -> showPage ('Error404View');
            return;
        }
        $connect = new UserDBModel;

        $user = $connect -> getForID($user_ID);
        $user ['ID'] = $user_ID;
        if (!($this -> getUserInfo($_SESSION['user_id'])['Accesslvl'] == 'admin'))
        {
            $this -> showPage ('Error404View');
            return;
        }

        $data_for_view ['other_user_data'] = $user;
        $data_for_view ['about_me'] = $this -> getUserInfo($_SESSION['user_id'])['About_me'];
        $this -> showPage ('OtherUserEditView',$data_for_view );
    }

    public function editSaveOtherUserData($user_ID)
    {
        if (!isset($_SESSION['user_id']))
        {
            $this -> showPage ('Error404View');
            return;
        }

        $connect = new UserDBModel;
        $user =
            [
                'user_ID' => $user_ID,
                'login' => $_POST["login"],
                'username' => $_POST["username"],
                'about_me' => $_POST["about"],
                'lvl' => $_POST["lvl"],
            ];
        $connect -> editOtherUser($user);
        $host  = $_SERVER['HTTP_HOST'];
        $location = 'Location: http://'.$host.'/user/'.$user_ID;
        header($location);
    }

    public function editDeleteOtherUserData($user_ID)
    {
        if (!isset($_SESSION['user_id']))
            if (!$this -> getUserInfo($_SESSION['user_id'])['Accessslvl'] !== 'admin')
            {
                $this -> showPage ('Error404View');
                return;
            }

        $connect = new UserDBModel;
        $connect -> deleteUser($user_ID);
        $host  = $_SERVER['HTTP_HOST'];
        $location = 'Location: http://'.$host.'/usertable';
        header($location);
    }

    public function editBanOtherUserData($user_ID)
    {
        if (!isset($_SESSION['user_id']))
            if (!$this -> getUserInfo($_SESSION['user_id'])['Accesslvl'] !== 'admin')
            {
                $this -> showPage ('Error404View');
                return;
            }

        $connect = new UserDBModel;
        $connect -> banUser($user_ID);
        $host  = $_SERVER['HTTP_HOST'];
        $location = 'Location: http://'.$host.'/user/'.$user_ID;
        header($location);
    }

    public function editUnbanOtherUserData($user_ID)
    {
        if (!isset($_SESSION['user_id']))
            if (!$this -> getUserInfo($_SESSION['user_id'])['Accessslvl'] !== 'admin')
            {
                $this -> showPage ('Error404View');
                return;
            }

        $connect = new UserDBModel;
        $connect -> unbanUser($user_ID);
        $host  = $_SERVER['HTTP_HOST'];
        $location = 'Location: http://'.$host.'/user/'.$user_ID;
        header($location);
    }
    
}
