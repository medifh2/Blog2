<?php
namespace Control;

use View\View;
use Model\PostDBModel;
use Model\CommDBModel;

class BlogController extends Controller
{

    function __construct()
    {

    }

    public function showBlogCreatePage()
    {
        View::pageGenerate ('BlogCreateView');
    }

    public function CreatePost()
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
                'image' => $image,
                'datepub' => date("y-m-d H:i:s ")
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
        foreach ($post as &$exemp)
        {
            $exemp['Image'] = 'images/'.$exemp['Image'];
        }
        $_SESSION['Userposts'] = $post;
        View:: pageGenerate ('UserBlogView');
    }

    public function fullPost()
    {


        $connect_postDB = new PostDBModel;

        $post = $connect_postDB -> getForIDPost($_POST["PostID"]);
        $_SESSION["ForFullPost"] = $post;
        $_SESSION["ForFullPost"]["PostID"] = $_POST["PostID"];
        $_SESSION["ForFullPost"]["Image"] = 'images/'.$_SESSION["ForFullPost"]["Image"];

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