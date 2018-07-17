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

    public function showPage($file_names, $data_for_view = NULL)
    {
        if (isset($_SESSION['user_id'])) $data_for_view['user'] = $this->getUserInfo();
        $files = array();
        $files['head'] = 'Top/Head';
        $files['nav'] = 'Top/Nav';
        if (isset($_SESSION['user_id']))
            if ($data_for_view['user']['Accesslvl'] == 'admin') $files['nav_content'] = 'AdminNav';
            else $files['nav_content'] = 'IsLoginNav';
        else $files['nav_content'] = 'IsNotLoginNav';
        $files['body'] = $file_names;
        if (!isset($data_for_view['query'])) $data_for_view['query'] = false;
        $data_for_view['is_posts_check'] = (isset($_GET['posts']) || ((!isset($_GET['query']) && !isset($_GET['users'])))) ? 'checked' : '';
        $data_for_view['is_userss_check'] = isset($_GET['users']) ? 'checked' : '';
        if (!isset($data_for_view['is_users_check'])) $data_for_view['is_users_check'] = false;
        View::pageGenerate($files, $data_for_view);
    }

    public function checkAccess($author_id, $role_for_access)
    {
        if (($role_for_access != 'anyone') && ($role_for_access != 'notlogin')) {
            if (isset($_SESSION['user_id'])) $user_role = $this->getUserInfo()['Accesslvl'];
            else return false;
            if ($user_role != 'admin') {
                if (!(($role_for_access == $user_role) || ($_SESSION['user_id'] == $author_id) || ($role_for_access == 'reader'))) return false;
            }
        } else {
            if (($role_for_access == 'notlogin') && (isset($_SESSION['user_id']))) return false;
        }
        return true;
    }

    public function showError404Page()
    {
        $this->showPage('Error404View');
    }

}