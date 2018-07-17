<?php
namespace Control;

use Model\UserDBModel;

class UserController extends Controller
{

    public function showSettings()
    {
        $this->showPage('UserProfileSettingsView');
    }

    public function showUserProfile()
    {
        $this->showPage('UserProfileView');
    }

    public function showOtherUserProfile($user_id)
    {

        $connect = new UserDBModel;
        $user = $connect->getForID($user_id);
        $user['ID'] = $user_id;
        $data_for_view['other_user_data'] = $user;
        $this->showPage('OtherUserProfileView', $data_for_view);
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        $host = $_SERVER['HTTP_HOST'];
        $route = 'Location: http://' . $host . '/';
        header($route);
    }

    public function login()
    {
        if (!isset($_POST['pass'])) {
            $this->showPage('LogView');
            return;
        }

        $connect = new UserDBModel;
        $login = $_POST["login"];
        $pass = md5($_POST["pass"]);
        if ($userdata = $connect->loginUser($login, $pass)) {
            $_SESSION['user_id'] = $userdata['ID'];
            $this->showPage('UserProfileView');
        } else {
            $data_for_view['error_message'] = 'Wrong password or login';
            $this->showPage('LogView', $data_for_view);
        }

    }

    public function registration()
    {
        if (!isset($_POST['pass'])) {
            $this->showPage('RegView');
            return;
        }

        $connect = new UserDBModel;

        $_POST["pass"] = str_replace(' ', '', $_POST["pass"]);
        $_POST["r_pass"] = str_replace(' ', '', $_POST["r_pass"]);
        $_POST["login"] = str_replace(' ', '', $_POST["login"]);
        $_POST["username"] = str_replace(' ', '', $_POST["username"]);
        $pass = $_POST["pass"];
        $r_pass = $_POST["r_pass"];
        if (!$pass || !$_POST["login"] || !$_POST["username"] || ($pass !== $r_pass)) {
            $date_for_view['error_message'] = 'Incorrect data!';
            $this->showPage('RegView', $date_for_view);
            return;
        }
        $pass = md5($pass);
        $user =
            [
                'login' => $_POST["login"],
                'pass' => $pass,
                'username' => $_POST["username"],
                'about_me' => '',
                'lvl' => 'reader',
                'reg_date' => date("y-m-d H:i:s "),
                'user_configs' => '',
                'status' => 'unban'
            ];
        if ($user['login'] = $connect->addUser($user)) {
            $_SESSION['user_id'] = $user['login'];
            $this->showPage('UserProfileView');
        } else {
            $date_for_view['error_message'] = 'A User with such data is already registered!';
            $this->showPage('RegView', $date_for_view);
            return;
        }
    }

    public function editUserData()
    {
        $connect = new UserDBModel;
        $_POST["n_pass"] = str_replace(' ', '', $_POST["n_pass"]);
        $_POST["c_pass"] = str_replace(' ', '', $_POST["c_pass"]);
        $_POST["n_username"] = str_replace(' ', '', $_POST["n_username"]);
        if ($_POST["n_pass"]) {
            $n_pass = md5($_POST["n_pass"]);
        } else $n_pass = false;
        $c_pass = md5($_POST["c_pass"]);
        $user =
            [
                'login' => $this->getUserInfo()['Login'],
                'pass' => $n_pass,
                'c_pass' => $c_pass,
                'username' => $_POST["n_username"],
                'about_me' => $_POST["n_about"],
            ];
        if ($connect->editUser($user)) {
            $data_for_view['message'] = 'Changes were saved';
            $this->showPage('UserProfileView', $data_for_view);
        } else {
            $error_message = "Wrong password";
            $data_for_view['error_message'] = $error_message;
            $this->showPage('UserProfileSettingsView', $data_for_view);
        }
    }

    public function showUsersTable()
    {
        $connect = new UserDBModel;
        $all_users = ($connect->getFromToUsers(0, 10));
        $data_for_view ['all_users'] = $all_users;
        $this->showPage('UserTableView', $data_for_view);
    }

    public function editOtherUserDataShow($user_ID)
    {
        $connect = new UserDBModel;
        $user = $connect->getForID($user_ID);
        $user ['ID'] = $user_ID;
        $data_for_view ['other_user_data'] = $user;
        $this->showPage('OtherUserEditView', $data_for_view);
    }

    public function editSaveOtherUserData($user_ID)
    {
        $connect = new UserDBModel;
        $user =
            [
                'user_ID' => $user_ID,
                'login' => $_POST["login"],
                'username' => $_POST["username"],
                'about_me' => $_POST["about"],
                'lvl' => $_POST["lvl"],
            ];
        $connect->editOtherUser($user);
        $host = $_SERVER['HTTP_HOST'];
        $location = 'Location: http://' . $host . '/user/' . $user_ID;
        header($location);
    }

    public function editDeleteOtherUserData($user_ID)
    {
        $connect = new UserDBModel;
        $connect->deleteUser($user_ID);
        $host = $_SERVER['HTTP_HOST'];
        $location = 'Location: http://' . $host . '/usertable';
        header($location);
    }

    public function editBanOtherUserData($user_ID)
    {
        $connect = new UserDBModel;
        $connect->banUser($user_ID);
        $host = $_SERVER['HTTP_HOST'];
        $location = 'Location: http://' . $host . '/user/' . $user_ID;
        header($location);
    }

    public function editUnbanOtherUserData($user_ID)
    {
        $connect = new UserDBModel;
        $connect->unbanUser($user_ID);
        $host = $_SERVER['HTTP_HOST'];
        $location = 'Location: http://' . $host . '/user/' . $user_ID;
        header($location);
    }

    public static function isLogged()
    {
        return isset($_SESSION['user_id']);
    }

    public static function isBanned()
    {
        if (UserController::isLogged()) {
            $connect = new UserDBModel;
            $user = $connect->getForID($_SESSION['user_id']);
            return ($user['Status'] == 'ban');
        } else return false;
    }

    public static function isLoggedAdmin()
    {
        if (UserController::isLogged()) {
            $connect = new UserDBModel;
            $user = $connect->getForID($_SESSION['user_id']);
            return ($user['Accesslvl'] === 'admin');
        } else return false;
    }

    public static function HasEditRights($post)
    {
        if (UserController::isLogged()) {
            $connect = new UserDBModel;
            $user = $connect->getForID($_SESSION['user_id']);
            return (($user['Login'] == $post['Author']) || (UserController::isLoggedAdmin()));
        } else return false;
    }

}
