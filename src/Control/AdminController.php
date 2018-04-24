<?php
namespace Control;

use Model\PostDBModel;
use Model\UserDBModel;
use View\View;
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
        View::pageGenerate ('UserTableView', $data_for_view);
    }

}
