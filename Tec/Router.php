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
            if (isset($arr_route[2])) $route_data = $arr_route[2];
            else $route_data = false;
            $routing = [
                '' => ['Control' => 'MainpageController', 'Action' => 'showMainPage'],
                'login' => ['Control' => 'UserController', 'Action' => 'login'],
                'registration' => ['Control' => 'UserController', 'Action' => 'registration'],
                'userpage' => ['Control' => 'BlogController', 'Action' => 'showUserBlog'],
                'profile' => ['Control' => 'UserController', 'Action' => 'showUserProfile'],
                'edituser' => ['Control' => 'UserController', 'Action' => 'editUserData'],
                'logout' => ['Control' => 'UserController', 'Action' => 'logout'],
                'changeabout' => ['Control' => 'UserController', 'Action' => 'changeAbout'],
                'blogcreate' => ['Control' => 'BlogController', 'Action' => 'showBlogCreatePage'],
                'settings' => ['Control' => 'UserController', 'Action' => 'showSettings'],
                'css' => ['Control' => 'UserController', 'Action' => 'showSettings'],
                'more' => ['Control' => 'MainpageController', 'Action' => 'showMore'],
                'post' => ['Control' => 'BlogController', 'Action' => 'fullPost'],
                'user' => ['Control' => 'UserController', 'Action' => 'showOtherUserProfile'],
                'createpost' => ['Control' => 'BlogController', 'Action' => 'createPost'],
                'createcomment' => ['Control' => 'CommentController', 'Action' => 'createComment'],
                'searching' => ['Control' => 'BlogController', 'Action' => 'searching'],
                'usertable' => ['Control' => 'AdminController', 'Action' => 'showUsersTable'],
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

