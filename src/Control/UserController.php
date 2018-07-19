<?php
namespace Control;

use Model\UserDBModel;

class UserController extends Controller
{

    public function showSettings()
    {
        $this->showPage('UserEditView');
    }

    public function showProfile($user_id = NULL)
    {
        if ($user_id == NULL) {
            $user_id = $_SESSION['user_id'];
        }
        $connect = new UserDBModel;
        $user = $connect->getForID($user_id);
        $data_for_view['user'] = $user;
        $this->showPage('ProfileView', $data_for_view);
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        $this->showURLPage('/');
    }

    public function login()
    {
        if (!isset($_POST["login"])||!isset($_POST["pass"])) {
            $this->showPage('LogView');
            return;
        }
        $connect = new UserDBModel;
        $login = $_POST["login"];
        $pass = md5($_POST["pass"]);
        if ($userdata = $connect->loginUser($login, $pass)) {
            $_SESSION['user_id'] = $userdata['ID'];
            $this->showURLPage('/profile');
        } else {
            $data_for_view['error_message'] = 'Wrong password or login';
            $this->showPage('LogView', $data_for_view);
        }
    }

    public function registration()
    {
        if (!isset($_POST["login"])||!isset($_POST["pass"])) {
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
            $this->showPage('ProfileView');
        } else {
            $date_for_view['error_message'] = 'A User with such data is already registered!';
            $this->showPage('RegView', $date_for_view);
        }
    }

    public function showUsersTable()
    {
        $connect = new UserDBModel;
        $all_users = ($connect->getFromToUsers(0, 10));
        $data_for_view ['all_users'] = $all_users;
        $this->showPage('UserTableView', $data_for_view);
    }

    public function showEditUserData($user_ID)
    {
        $connect = new UserDBModel;
        $user = $connect->getForID($user_ID);
        $data_for_view ['user'] = $user;
        $this->showPage('ProfileEditView', $data_for_view);
    }

    public function saveEditedUserData($user_ID)
    {
        $connect = new UserDBModel;
        $_POST["n_pass"] = str_replace(' ', '', $_POST["n_pass"]);
        $_POST["c_pass"] = str_replace(' ', '', $_POST["c_pass"]);
        $_POST["n_username"] = str_replace(' ', '', $_POST["n_username"]);
        $n_pass = ($_POST["n_pass"]) ? md5($_POST["n_pass"]): $n_pass = false;
        $c_pass = md5($_POST["c_pass"]);
        $user =
            [
                'user_ID' => $user_ID,
                'login' => $this->getUserInfo()['Login'],
                'pass' => $n_pass,
                'c_pass' => $c_pass,
                'username' => $_POST["n_username"],
                'about_me' => $_POST["n_about"],
                'lvl' => $_POST["lvl"],
            ];
        print_r ($_POST["n_about"]);
        if ($connect->editUser($user, UserController::isLoggedAdmin())) {
            $data_for_view['message'] = 'Changes were saved';
            $this->showURLPage('/user/' . $user_ID);
        } else {
            $error_message = "Wrong password";
            $data_for_view['error_message'] = $error_message;
            $this->showPage('ProfileEditView', $data_for_view);
        }

    }

    public function deleteUserData($user_ID)
    {
        $connect = new UserDBModel;
        $connect->deleteUser($user_ID);
        $this->showURLPage('/usertable');
    }

    public function banUser($user_ID)
    {
        $connect = new UserDBModel;
        $connect->banUser($user_ID);
        $this->showURLPage('/user/' . $user_ID);
    }

    public function unbanUser($user_ID)
    {
        $connect = new UserDBModel;
        $connect->unbanUser($user_ID);
        $this->showURLPage('/user/' . $user_ID);
    }

    public static function isLogged()
    {
        return isset($_SESSION['user_id']);
    }

    public static function isBanned($user_id = NULL)
    {
        if (($user_id == NULL) && UserController::isLogged()) {
            $user_id = $_SESSION['user_id'];
        }
        if ($user_id != NULL) {
            $connect = new UserDBModel;
            $user = $connect->getForID($user_id);
            return ($user['Status'] == 'banned');
        } else {
            return false;
        }
    }

    public static function isLoggedAdmin()
    {
        if (UserController::isLogged()) {
            $connect = new UserDBModel;
            $user = $connect->getForID($_SESSION['user_id']);
            return ($user['Accesslvl'] === 'admin');
        } else {
            return false;
        }
    }

    public static function isUserAdmin($user_id)
    {
        return (UserController::isLoggedAdmin() && ($_SESSION['user_id'] == $user_id));
    }

    public static function hasPostCreatingRights()
    {
        if (UserController::isLogged()) {
            $connect = new UserDBModel;
            $user = $connect->getForID($_SESSION['user_id']);
            return ($user['Accesslvl'] !== 'reader');
        } else {
            return false;
        }
    }

    public static function hasEditPostRights($post)
    {
        if (UserController::isLogged()) {
            return (($_SESSION['user_id'] == $post['Author']) || (UserController::isLoggedAdmin()));
        } else {
            return false;
        }
    }

    public static function checkAccess($author_id, $role)
    {
        $connect = new UserDBModel;
        if (($role != 'anyone') && ($role != 'notlogin')) {
            if (isset($_SESSION['user_id']))  $user_role = $connect->getForID($_SESSION['user_id'])['Accesslvl'];
            else return false;
            if ($user_role != 'admin') {
                if (!(($role == $user_role) || ($_SESSION['user_id'] == $author_id) || ($role == 'reader'))) return false;
            }
        } else {
            if (($role == 'notlogin') && (isset($_SESSION['user_id']))) return false;
        }
        return true;
    }

    public static function hasEditProfileRights($profile_id)
    {
        if (UserController::isLogged()) {
            return (($profile_id == $_SESSION['user_id']) || (UserController::isLoggedAdmin()));
        } else {
            return false;
        }
    }

    public static function getNameForID($user_id)
    {
        $connect = new UserDBModel;
        if ($user = $connect->getForID($user_id)) {
            return $user['Username'];
        }
        else{
            return 'Unknown';
        }
    }

}
