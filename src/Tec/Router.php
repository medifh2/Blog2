<?php
namespace Tec;

use View\View;

class Router
{
    public
    function __construct()
    {
        $route = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $arr_route = explode('/', $route);
        $route = $arr_route[1];
        $route_data = (isset($arr_route[2])) ? $arr_route[2] : false;
        $routing = [
            '' => ['Control' => 'BlogController', 'Action' => 'showMainPage', 'RoleAccess' => 'anyone'],
            'login' => ['Control' => 'UserController', 'Action' => 'login', 'RoleAccess' => 'notlogin'],
            'registration' => ['Control' => 'UserController', 'Action' => 'registration', 'RoleAccess' => 'notlogin'],
            'userpage' => ['Control' => 'BlogController', 'Action' => 'showUserBlog', 'RoleAccess' => 'reader'],
            'profile' => ['Control' => 'UserController', 'Action' => 'showUserProfile', 'RoleAccess' => 'reader'],
            'user' => ['Control' => 'UserController', 'Action' => 'showOtherUserProfile' , 'RoleAccess' => 'anyone'],
            'logout' => ['Control' => 'UserController', 'Action' => 'logout', 'RoleAccess' => 'reader'],
            'changeabout' => ['Control' => 'UserController', 'Action' => 'changeAbout', 'RoleAccess' => 'author'],
            'blogcreate' => ['Control' => 'BlogController', 'Action' => 'showPostCreatePage', 'RoleAccess' => 'writer'],
            'settings' => ['Control' => 'UserController', 'Action' => 'showSettings', 'RoleAccess' => 'author'],
            'css' => ['Control' => 'UserController', 'Action' => 'showSettings', 'RoleAccess' => 'author'],
            'page' => ['Control' => 'BlogController', 'Action' => 'showNPage', 'RoleAccess' => 'anyone'],
            'post' => ['Control' => 'BlogController', 'Action' => 'fullPost', 'RoleAccess' => 'anyone'],
            'edituser' => ['Control' => 'UserController', 'Action' => 'editUserData', 'RoleAccess' => 'author'],
            'createpost' => ['Control' => 'BlogController', 'Action' => 'createPost', 'RoleAccess' => 'writer'],
            'createcomment' => ['Control' => 'CommentController', 'Action' => 'createComment', 'RoleAccess' => 'writer'],
            'commentedit' => ['Control' => 'CommentController', 'Action' => 'commentEditShow', 'RoleAccess' => 'author'],
            'commenteditsave' => ['Control' => 'CommentController', 'Action' => 'commentEditSave', 'RoleAccess' => 'author'],
            'commenteditdelete' => ['Control' => 'CommentController', 'Action' => 'commentEditDelete', 'RoleAccess' => 'author'],
            'search' => ['Control' => 'BlogController', 'Action' => 'search', 'RoleAccess' => 'anyone'],
            'usertable' => ['Control' => 'UserController', 'Action' => 'showUsersTable', 'RoleAccess' => 'admin'],
            'otheruseredit' => ['Control' => 'UserController', 'Action' => 'editOtherUserDataShow', 'RoleAccess' => 'admin'],
            'otherusereditsave' => ['Control' => 'UserController', 'Action' => 'editSaveOtherUserData', 'RoleAccess' => 'admin'],
            'otherusereditdelete' => ['Control' => 'UserController', 'Action' => 'editDeleteOtherUserData', 'RoleAccess' => 'admin'],
            'otherusereditban' => ['Control' => 'UserController', 'Action' => 'editBanOtherUserData', 'RoleAccess' => 'admin'],
            'otherusereditunban' => ['Control' => 'UserController', 'Action' => 'editUnbanOtherUserData', 'RoleAccess' => 'admin'],
            'postedit' => ['Control' => 'BlogController', 'Action' => 'postEditShow', 'RoleAccess' => 'author'],
            'posteditsave' => ['Control' => 'BlogController', 'Action' => 'postEditSave', 'RoleAccess' => 'author'],
            'posteditdelete' => ['Control' => 'BlogController', 'Action' => 'postEditDelete', 'RoleAccess' => 'author'],
        ];
        
        $controller_type = '\\Control\\Controller';
        $check_access_controller  = new $controller_type();
        $author_id = ($route == 'user') ? $arr_route[2] : false;
        if (isset($routing[$arr_route[1]])&&($check_access_controller->checkAccess($author_id, $routing[$route]['RoleAccess']))) {
            
            $controller = '\\Control\\' . $routing[$route]['Control'];
            $controller_obj = new $controller();
            $act = $routing[$route]['Action'];
            $controller_obj->$act($route_data);
        } else {

            $check_access_controller -> showPage('Error404View');
        }
    }
}

