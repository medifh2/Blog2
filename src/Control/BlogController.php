<?php
namespace Control;

use View\View;
use Model\PostDBModel;
use Model\CommDBModel;
use Model\UserDBModel;

class BlogController extends Controller
{

    function __construct()
    {

    }

    public function showBlogCreatePage()
    {
        View::pageGenerate ('BlogCreateView');
    }

    public function createPost()
    {
        $connect = new PostDBModel;
        if ((!isset($_POST["text"]) && !isset($_FILES["image"])) || (!$_POST["title"]))
        {
            $_SESSION['error_message'] = 'Wrong Data';
            View::pageGenerate ('BlogCreateView');
            return;
        }
        if (isset ($_FILES['image']))
        {
            $target = "images/".($_FILES['image']['name']);
            $image = $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'],$target);
        }
        else $image = "";

        if (isset($_POST["status"]))
        {
            $status = "published";
        }
        else $status = "unpublished";

        if (isset ($_POST["text"]))
        {
            $text = $_POST['text'];
        }
        else $text = "";
        $post =
            [
                'title' => $_POST["title"],
                'author' => $_SESSION['Userdata']['Login'],
                'text' => $text,
                'image' => 'images/'.$image,
                'datepub' => date("y-m-d H:i:s "),
                'status' => $status,
            ];

        if ($connect -> addPost($post))
        {
            $this -> showUserBlog();
        }
        else {
            $_SESSION['error_message'] = 'Unknown error';
            View::pageGenerate ('BlogCreateView');
        }
    }

    public function showUserBlog()
    {
        $connect = new PostDBModel;
        $post = $connect -> getForLoginPost($_SESSION['Userdata']['Login']);

        $_SESSION['Userposts'] = $post;
        View:: pageGenerate ('UserBlogView');
    }

    public function searching()
    {
        $connect_post = new PostDBModel;
        $connect_user = new UserDBModel;

        if (isset($_POST["Author_login"]) && $_POST["Author_login"])
        {
            $_POST["Author_login"] = str_replace(' ','',$_POST["Author_login"]);
            $login = $_POST["Author_login"];
        }
        else $login = false;

        if (isset($_POST["Author_username"]) && $_POST["Author_username"])
        {
            $_POST["Author_username"] = str_replace(' ','',$_POST["Author_username"]);
            $username = $_POST["Author_username"];
        }
        else $username = false;

        if (isset($_POST["Title"]) && $_POST["Title"])
        {
            $_POST["Title"] = str_replace(' ','',$_POST["Title"]);
            $title = $_POST["Title"];
        }
        else $title = false;

        if (isset($_POST["From"]) && $_POST["From"])
        {
            $_POST["From"] = str_replace(' ','',$_POST["From"]);
            $date_from = $_POST["From"];
        }
        else $date_from = "0000:01:01 00-00-00";

        if (isset($_POST["To"]) && $_POST["To"])
        {
            $_POST["To"] = str_replace(' ','',$_POST["To"]);
            $date_to = $_POST["To"];
        }
        else $date_to = "9999:01:01 00-00-00";

        if (!$login)
        {
            $login_arr = $connect_user->getInfoForName($username);
        }
        else {
            if ($login)
            {
                $login_arr = [ '0' => $login];
            }
            else $login_arr = false;
        }
        if ($login_arr)
        {
            $_SESSION["Found_author"] = $login_arr;
        }
        if (!$title || !$login_arr || ($date_from !== "0000:01:01 00-00-00" && $date_to !== "9999:01:01 00-00-00"))
        {
            $post = $connect_post->getForDataPost($login_arr, $date_from, $date_to, $title);
            $_SESSION["Found_post"] = $post;
        }
        
        View:: pageGenerate ('SearchResultView');
    }

    public function fullPost()
    {

        if (!isset($_POST["PostID"]))
        {
            View:: pageGenerate ('Error404View');
            return;
        }

        $connect_postDB = new PostDBModel;

        $post = $connect_postDB -> getForIDPost($_POST["PostID"]);
        $_SESSION["ForFullPost"] = $post;
        $_SESSION["ForFullPost"]["PostID"] = $_POST["PostID"];
        $connect_commDB = new CommDBModel;
        if ($comment = $connect_commDB -> getForPostIDComment($_SESSION["ForFullPost"]["PostID"]))
        {
            $_SESSION["Comments"] = $comment;
        }
        else
        {
            $_SESSION["Comments"] = false;
        }

        View:: pageGenerate ('FullPostView');
    }

}