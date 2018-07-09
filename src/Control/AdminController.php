<?php
namespace Control;

use Model\PostDBModel;
use Model\UserDBModel;

class AdminController extends Controller
{

    function __construct()
    {

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
        if (!$_SESSION['is_login'])
        {
            $this -> showPage ('Error404View');
            return;
        }
        $connect = new UserDBModel;

        $user = $connect -> getForID($user_ID);
        $user ['ID'] = $user_ID;
        if (!($_SESSION['userdata']['lvl'] == 'admin'))
        {
            $this -> showPage ('Error404View');
            return;
        }

        $data_for_view ['other_user_data'] = $user;
        $this -> showPage ('OtherUserEditView',$data_for_view );
    }
    
    public function editSaveOtherUserData($user_ID)
    {
        if (!$_SESSION['is_login'])
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
        if (!$_SESSION['is_login'])
            if (!$_SESSION['userdata']['lvl'] !== 'admin')
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
        if (!$_SESSION['is_login'])
            if (!$_SESSION['userdata']['lvl'] !== 'admin')
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
        if (!$_SESSION['is_login'])
            if (!$_SESSION['userdata']['lvl'] !== 'admin')
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
