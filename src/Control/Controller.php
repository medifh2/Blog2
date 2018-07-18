<?php
namespace Control;

use View\View;
use Model\UserDBModel;

class Controller
{

    protected function getUserInfo()
    {
        if (isset($_SESSION['user_id'])) {
            $connect = new UserDBModel;
            $user = $connect->getForID($_SESSION['user_id']);
            return $user;
        } else
            return null;
    }

    public function showPage($file_name, $data_for_view = NULL)
    {
        if (isset($_SESSION['user_id'])) $data_for_view['user'] = $this->getUserInfo();
        if (!isset($data_for_view['query'])) $data_for_view['query'] = false;
        $data_for_view['is_posts_check'] = (isset($_GET['posts']) || ((!isset($_GET['query']) && !isset($_GET['users'])))) ? 'checked' : '';
        $data_for_view['is_userss_check'] = isset($_GET['users']) ? 'checked' : '';
        if (!isset($data_for_view['is_users_check'])) $data_for_view['is_users_check'] = false;
        View::generatePage($file_name, $data_for_view);
    }

    public function showError404Page()
    {
        $this->showPage('Error404View');
    }

}