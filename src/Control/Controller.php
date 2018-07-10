<?php
namespace Control;
use View\View;
use Model\UserDBModel;

class Controller
{

    protected function showPage($file_name, $data_for_view = NULL)
    {
        View::pageGenerate($file_name, $data_for_view);
    }
    
    protected  function getUserInfo($user_id)
    {
        if (isset($_SESSION['user_id'])) {
            $connect = new UserDBModel;
            $user = $connect->getForID($_SESSION['user_id']);
            return $user;
        }
        else 
            return null;
    }
}