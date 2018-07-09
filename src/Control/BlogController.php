<?php
namespace Control;

use Model\PostDBModel;
use Model\CommDBModel;
use Model\UserDBModel;

class BlogController extends Controller
{

    function __construct()
    {
        if (!$_SESSION['is_login'])
            if (!$_SESSION['userdata']['lvl'] = 'admin')
        {
            $this -> showPage ('Error404View');
            return;
        }
    }

    public function postEditShow($post_ID)
    {

        if (!$_SESSION['is_login'])
        {
            $this -> showPage ('Error404View');
            return;
        }
        $connect = new PostDBModel;

        $post = $connect -> getForIDPost($post_ID);
        if (!(($post['Author'] == $_SESSION['userdata']['login']) || ($_SESSION['userdata']['lvl'] == 'admin')))
        {
            $this -> showPage ('Error404View');
            return;
        }
        
        $data_for_view ['post'] = $post;
        $this -> showPage ('PostEditView',$data_for_view );
    }

    public function postEditDelete($post_ID)
    {
        if (!$_SESSION['is_login'])
        {
            $this -> showPage ('Error404View');
            return;
        }

        $connect = new PostDBModel;
        $connect -> deletePost($post_ID);
        $_SESSION['message'] = 'Sucsess';
        $this -> showPage ('MainpageView');
    }
    
    public function postEditSave($post_ID)
    {
        if (!$_SESSION['is_login'])
        {
            $this -> showPage ('Error404View');
            return;
        }
        
        $connect = new PostDBModel;
        $post = $connect -> getForIDPost($post_ID);
        
        if (!(($post['Author'] == $_SESSION['userdata']['login']) || ($_SESSION['userdata']['lvl'] == 'admin')))
        {
            $this -> showPage ('Error404View');
            return;
        }

        if ((!isset($_POST["text"]) && !isset($_FILES["image"])) || (!$_POST["title"]))
        {
            $data_for_view ['post'] = $post;
            $error_message = 'Wrong Data';
            $data_for_view['error_message'] = $error_message;
            $this -> showPage ('PostEditView', $data_for_view);
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
            $status = 'published';
        }
        else $status = 'unpublished';

        if (isset ($_POST['text']))
        {
            $text = $_POST['text'];
        }
        else $text = "";
        
        $post =
            [
                'title' => $_POST["title"],
                'author' => $_SESSION['userdata']['login'],
                'text' => $text,
                'image' => 'images/'.$image,
                'datepub' => date("y-m-d H:i:s "),
                'status' => $status,
                'post_ID'=> $post_ID
            ];
        if ($connect -> editPost($post))
        {
            $host  = $_SERVER['HTTP_HOST'];
            $page = 'Location: http://'.$host.'/post/'.$post_ID;
            header($page);
        }
        else {
            $post = $connect -> getForIDPost($post_ID);
            $data_for_view ['post'] = $post;
            $error_message = 'Unknown error';
            $data_for_view ['error_message'] = $error_message;
            $this -> showPage ('PostEditView', $data_for_view);
        }
    }
    
    public function showBlogCreatePage()
    {
        if (!$_SESSION['is_login'])
            if ($_SESSION['userdata']['lvl'] = 'reader')
            {
                $this -> showPage('Error404View');
                return;
            }

        $this -> showPage ('BlogCreateView');
    }

    public function createPost()
    {
        if (!$_SESSION['is_login'])
            if ($_SESSION['userdata']['lvl'] = 'reader')
            {
                $this -> showPage('Error404View');
                return;
            }

        $connect = new PostDBModel;
        if ((!isset($_POST["text"]) && !isset($_FILES["image"])) || (!$_POST["title"]))
        {
            $error_message = 'Wrong Data';
            $data_for_view['error_message'] = $error_message;
            $this -> showPage ('BlogCreateView', $data_for_view);
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
            $status = 'published';
        }
        else $status = 'unpublished';

        if (isset ($_POST['text']))
        {
            $text = $_POST['text'];
        }
        else $text = "";
        $post =
            [
                'title' => $_POST["title"],
                'author' => $_SESSION['userdata']['login'],
                'text' => $text,
                'image' => 'images/'.$image,
                'datepub' => date("y-m-d H:i:s "),
                'status' => $status,
            ];
        if ($connect -> addPost($post))
        {
            $this->showPage('UserBlogView');
        }
        else {
            $error_message = 'Unknown error';
            $data_for_view ['error_message'] = $error_message;
            $this -> showPage ('BlogCreateView', $data_for_view);
        }
    }

    public function showUserBlog()
    {
        if (!$_SESSION['is_login'])
            {
                $this -> showPage('Error404View');
                return;
            }

        $connect = new PostDBModel;
        $userposts = $connect -> getForLoginPost($_SESSION['userdata']['login']);
        $data_for_view['userposts'] = $userposts;
        $this -> showPage ('UserBlogView',$data_for_view);
    }

    public function searching()
    {
        $connect_post = new PostDBModel;
        $connect_user = new UserDBModel;
        $_POST['query'] = str_replace(' ','',$_POST['query']);
        $query = $_POST['query'];
        
        if (isset($_POST['users']))$data_for_view['users'] = true;
        else $data_for_view['users'] = false;
        
        if (isset($_POST['posts']))$data_for_view['posts'] = true;
        else $data_for_view['posts'] = false;
        
        if ($query)
        {
            $posts = $connect_post->getForQuery($query);
            $authors = $connect_user->getForQuery($query);
            $data_for_view['found_post'] = $posts;
            $data_for_view['found_author'] = $authors;
        }
        else {
            $data_for_view['found_post'] = false;
            $data_for_view['found_author'] = false;
        }
        $this -> showPage ('SearchResultView', $data_for_view);
       /* if (isset($_POST["Author_login"]) && $_POST["Author_login"])
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
        if ($found_author = $login_arr);
        else 
        {
            $found_author = false;
        }
        if (!$title || !$login_arr || ($date_from !== "0000:01:01 00-00-00" && $date_to !== "9999:01:01 00-00-00"))
        {
            if ($found_post = $connect_post->getForDataPost($login_arr, $date_from, $date_to, $title)); 
            else
            {
            $found_post = false;
            }
        }
        else
        {
            $found_post = false;
        }
        $data_for_view['found_post'] = $found_post;
        $data_for_view['found_author'] = $found_author;
        View:: pageGenerate ('SearchResultView', $data_for_view);*/
    }

    public function fullPost($route_data)
    {

        if (!$route_data)
        {
            $this -> showPage ('Error404View');
            return;
        }
        $post_ID =  $route_data;
        $connect_postDB = new PostDBModel;

        $post = $connect_postDB -> getForIDPost($post_ID);

        $connect_commDB = new CommDBModel;
        if ($comments = $connect_commDB -> getForPostIDComment($post_ID));
        else
        {
            $comments = false;
        }
        $data_for_view =
            [
                'post' => $post,
                'post_ID' => $post_ID,
                'comments' => $comments
            ];
        $this -> showPage ('FullPostView', $data_for_view);
    }

}