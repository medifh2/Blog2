<?php
namespace Control;

use View\View;
use Model\PostDBModel;

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
            $connect = new PostDBModel;
            $post = $connect->getLoginPost($_SESSION['Userdata']['Login']);
            foreach ($post as &$exemp)
            {
                $exemp['Image'] = 'images/'.$exemp['Image'];
            }
            $_SESSION['Userposts'] = $post;
            View::pageGenerate ('UserBlogView');
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
        $connect = new PostDBModel;
        $post = $connect -> getForIDPost($_POST["PostID"]);
        $_SESSION["ForFullPost"] = $post;
        $_SESSION["ForFullPost"]["Image"] = 'images/'.$_SESSION["ForFullPost"]["Image"];
        View:: pageGenerate ('FullPostView');
    }
}