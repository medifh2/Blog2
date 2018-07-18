<?php
namespace Tec;

use Control\Controller;
use Control\UserController;
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
            'profile' => ['Control' => 'UserController', 'Action' => 'showProfile', 'RoleAccess' => 'reader'],
            'user' => ['Control' => 'UserController', 'Action' => 'showProfile' , 'RoleAccess' => 'anyone'],
            'logout' => ['Control' => 'UserController', 'Action' => 'logout', 'RoleAccess' => 'reader'],
            'blogcreate' => ['Control' => 'BlogController', 'Action' => 'showPostCreate', 'RoleAccess' => 'writer'],
            'settings' => ['Control' => 'UserController', 'Action' => 'showEditUserData', 'RoleAccess' => 'author'],
            'page' => ['Control' => 'BlogController', 'Action' => 'showMainPage', 'RoleAccess' => 'anyone'],
            'post' => ['Control' => 'BlogController', 'Action' => 'showFullPost', 'RoleAccess' => 'anyone'],
            'edituser' => ['Control' => 'UserController', 'Action' => 'editUserData', 'RoleAccess' => 'author'],
            'createpost' => ['Control' => 'BlogController', 'Action' => 'savePost', 'RoleAccess' => 'writer'],
            'createcomment' => ['Control' => 'CommentController', 'Action' => 'createComment', 'RoleAccess' => 'writer'],
            'commentedit' => ['Control' => 'CommentController', 'Action' => 'showEditComment', 'RoleAccess' => 'author'],
            'commenteditsave' => ['Control' => 'CommentController', 'Action' => 'saveEditedComment', 'RoleAccess' => 'author'],
            'commenteditdelete' => ['Control' => 'CommentController', 'Action' => 'deleteComment', 'RoleAccess' => 'author'],
            'search' => ['Control' => 'BlogController', 'Action' => 'search', 'RoleAccess' => 'anyone'],
            'usertable' => ['Control' => 'UserController', 'Action' => 'showUsersTable', 'RoleAccess' => 'admin'],
            'otheruseredit' => ['Control' => 'UserController', 'Action' => 'showEditUserData', 'RoleAccess' => 'admin'],
            'otherusereditsave' => ['Control' => 'UserController', 'Action' => 'saveEditedUserData', 'RoleAccess' => 'admin'],
            'otherusereditdelete' => ['Control' => 'UserController', 'Action' => 'deleteUserData', 'RoleAccess' => 'admin'],
            'otherusereditban' => ['Control' => 'UserController', 'Action' => 'banUserData', 'RoleAccess' => 'admin'],
            'otherusereditunban' => ['Control' => 'UserController', 'Action' => 'unbanUserData', 'RoleAccess' => 'admin'],
            'postedit' => ['Control' => 'BlogController', 'Action' => 'showEditPost', 'RoleAccess' => 'author'],
            'posteditsave' => ['Control' => 'BlogController', 'Action' => 'savePost', 'RoleAccess' => 'author'],
            'posteditdelete' => ['Control' => 'BlogController', 'Action' => 'deletePost', 'RoleAccess' => 'author'],
        ];

        $author_id = ($route == 'user') ? $arr_route[2] : false;

        if (isset($routing[$arr_route[1]])&&(UserController::checkAccess($author_id, $routing[$route]['RoleAccess']))) {
            $controller = '\\Control\\' . $routing[$route]['Control'];
            $controller_obj = new $controller();
            $act = $routing[$route]['Action'];
            $controller_obj->$act($route_data);

        } else {

            $controller = "\\Control\\Controller";
            $controller_obj = new $controller();
            $act = 'showError404Page';
            $controller_obj->$act($route_data);
        }
    }
}

