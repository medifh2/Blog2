<?php
namespace View;

use Conf\LogoInfo;
use Control\Controller;
use Control\UserController;

class View
{
    private static function completeFileName($name)
    {
        switch ($name) {
            case 'LogView': {
                $path = 'Authorization/' . $name;
                break;
            }
            case 'RegView': {
                $path = 'Authorization/' . $name;
                break;
            }
            case 'CommentEditView': {
                $path = 'Comment/' . $name;
                break;
            }
            case 'CommentView': {
                $path = 'Comment/' . $name;
                break;
            }
            case 'MainPageView': {
                $path = 'MainPage/' . $name;
                break;
            }
            case 'FeedView': {
                $path = 'Post/' . $name;
                break;
            }
            case 'FullPostView': {
                $path = 'Post/' . $name;
                break;
            }
            case 'PostCreateView': {
                $path = 'Post/' . $name;
                break;
            }
            case 'PostEditView': {
                $path = 'Post/' . $name;
                break;
            }
            case 'PostView': {
                $path = 'Post/' . $name;
                break;
            }
            case 'ProfileView': {
                $path = 'Profile/' . $name;
                break;
            }
            case 'ProfileEditView': {
                $path = 'Profile/' . $name;
                break;
            }
            case 'SearchResultView': {
                $path = 'Search/' . $name;
                break;
            }
            case 'SearchForm': {
                $path = 'Search/' . $name;
                break;
            }
            case 'AlertView': {
                $path = 'System/' . $name;
                break;
            }
            case 'Error404View': {
                $path = 'System/' . $name;
                break;
            }
            case 'UserTableView': {
                $path = 'System/' . $name;
                break;
            }
            case 'UserBlogView': {
                $path = 'UserBlog/' . $name;
                break;
            }
            case 'AdminNav': {
                $path = 'Top/' . $name;
                break;
            }
            case 'HeadNav': {
                $path = 'Top/' . $name;
                break;
            }
            case 'IsLoginNav': {
                $path = 'Top/' . $name;
                break;
            }
            case 'IsNotLoginNav': {
                $path = 'Top/' . $name;
                break;
            }
            case 'Nav': {
                $path = 'Top/' . $name;
                break;
            }

            default:
                $path = 'System/Error404View';
        }
        return $path;
    }

    public static function generatePage($file_name, $data_for_view = NULL)
    {
        $files = array();
        $files['head'] = 'Top/Head';
        $files['nav'] = 'Top/Nav';
        if (isset($_SESSION['user_id']))
            if (UserController::isLoggedAdmin()) $files['nav_content'] = 'AdminNav';
            else $files['nav_content'] = 'IsLoginNav';
        else $files['nav_content'] = 'IsNotLoginNav';

        $files['body'] = View::completeFileName($file_name);

        $logo_info = new LogoInfo;
        $data_for_view['logo'] = $logo_info->getData();
        include $files['head'] . ".php";
        include $files['nav'] . ".php";
        include "System/AlertView.php";
        echo '<body>';
        include $files['body'] . ".php";

        echo '<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
              <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
              <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>';
        echo '</body>';
    }

    public static function attachUnit($name, $data_for_view = NULL)
    {
        $file = View::completeFileName($name);
        include $file . ".php";
        return;
    }

    private static $_instance = null;

    private function __construct()
    {

    }

    protected function __clone()
    {

    }

    static public function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

}