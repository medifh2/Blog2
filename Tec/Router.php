<?php
    namespace Tec;
    use View\View;
    class Router
    {
        public
        function __construct()
        {
            $route = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
            $routing = [
                '/' => ['Control' => 'MainpageController', 'Action' => 'showMainPage'],
                '/login' => ['Control' => 'UserController', 'Action' => 'showLoginPage'],
                '/registration' => ['Control' => 'UserController', 'Action' => 'showRegPage'],
                '/userpage' => ['Control' => 'BlogController', 'Action' => 'showUserBlog'],
                '/profile' => ['Control' => 'UserController', 'Action' => 'showUserProfile'],
                '/loguser' => ['Control' => 'UserController', 'Action' => 'login'],
                '/reguser' => ['Control' => 'UserController', 'Action' => 'registration'],
                '/edituser' => ['Control' => 'UserController', 'Action' => 'editUserData'],
                '/logout' => ['Control' => 'UserController', 'Action' => 'logout'],
                '/changeabout' => ['Control' => 'UserController', 'Action' => 'changeAbout'],
                '/blogcreate' => ['Control' => 'BlogController', 'Action' => 'showBlogCreatePage'],
                '/settings' => ['Control' => 'UserController', 'Action' => 'showSettings'],
                '/css' => ['Control' => 'UserController', 'Action' => 'showSettings'],
                '/more' => ['Control' => 'MainpageController', 'Action' => 'showMore'],
                '/createpost' => ['Control' => 'BlogController', 'Action' => 'CreatePost']
            ];
            if(isset($routing[$route]))
            {
                $controller = '\\Control\\'.$routing[$route]['Control'];
                $controller_obj = new $controller();
                $act = $routing[$route]['Action'];
                $controller_obj -> $act();
            }
            else {
                View::pagegenerate ('Error404View');
            }
        }
    }

