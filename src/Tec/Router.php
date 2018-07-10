<?php
    namespace Tec;
    use View\View;
    class Router
    {
        public
        function __construct()
        {
            $route = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
            $arr_route = explode ('/' , $route);
            $route = $arr_route[1];
            //$action = $arr_route[2];
            if (isset($arr_route[2])) $route_data = $arr_route[2];
            else $route_data = false;
            $routing = [
                '' => ['Control' => 'BlogController', 'Action' => 'showMainPage'],
                'login' => ['Control' => 'UserController', 'Action' => 'login'],
                'registration' => ['Control' => 'UserController', 'Action' => 'registration'],
                'userpage' => ['Control' => 'BlogController', 'Action' => 'showUserBlog'],
                'profile' => ['Control' => 'UserController', 'Action' => 'showUserProfile'],
                'user' => ['Control' => 'UserController', 'Action' => 'showOtherUserProfile'],
                'logout' => ['Control' => 'UserController', 'Action' => 'logout'],
                'changeabout' => ['Control' => 'UserController', 'Action' => 'changeAbout'],
                'blogcreate' => ['Control' => 'BlogController', 'Action' => 'showBlogCreatePage'],
                'settings' => ['Control' => 'UserController', 'Action' => 'showSettings'],
                'css' => ['Control' => 'UserController', 'Action' => 'showSettings'],
                'page' => ['Control' => 'BlogController', 'Action' => 'showNPage'],
                'post' => ['Control' => 'BlogController', 'Action' => 'fullPost'],
                'user' => ['Control' => 'UserController', 'Action' => 'showOtherUserProfile'],
                'edituser' => ['Control' => 'UserController', 'Action' => 'editUserData'],
                'createpost' => ['Control' => 'BlogController', 'Action' => 'createPost'],
                'createcomment' => ['Control' => 'CommentController', 'Action' => 'createComment'],
                'commentedit' => ['Control' => 'CommentController', 'Action' => 'commentEditShow'],
                'commenteditsave' => ['Control' => 'CommentController', 'Action' => 'commentEditSave'],
                'commenteditdelete' => ['Control' => 'CommentController', 'Action' => 'commentEditDelete'],
                'search' => ['Control' => 'BlogController', 'Action' => 'search'],
                'usertable' => ['Control' => 'UserController', 'Action' => 'showUsersTable'],
                'otheruseredit' => ['Control' => 'UserController', 'Action' => 'editOtherUserDataShow'],
                'otherusereditsave' => ['Control' => 'UserController', 'Action' => 'editSaveOtherUserData'],
                'otherusereditdelete' => ['Control' => 'UserController', 'Action' => 'editDeleteOtherUserData'],
                'otherusereditban' => ['Control' => 'UserController', 'Action' => 'editBanOtherUserData'],
                'otherusereditunban' => ['Control' => 'UserController', 'Action' => 'editUnbanOtherUserData'],
                'postedit' => ['Control' => 'BlogController', 'Action' => 'postEditShow'],
                'posteditsave' => ['Control' => 'BlogController', 'Action' => 'postEditSave'],
                'posteditdelete' => ['Control' => 'BlogController', 'Action' => 'postEditDelete'],
            ];


            if(isset($routing[$arr_route[1]]))
            {
                $controller = '\\Control\\'.$routing[$route]['Control'];
                $controller_obj = new $controller();
                $act = $routing[$route]['Action'];
                $controller_obj -> $act($route_data);
            }
            else {
                View::pagegenerate ('Error404View');
            }
        }
    }

