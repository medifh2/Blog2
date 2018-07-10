<?php
namespace Control;

use Model\PostDBModel;
use Model\CommDBModel;
use Model\UserDBModel;
class BlogController extends Controller
{

    function __construct()
    {
        if (isset($_SESSION['user_id']))
            if (!$this -> getUserInfo($_SESSION['user_id'])['Accesslvl'] == 'admin')
        {
            $this -> showPage ('Error404View');
            return;
        }
    }

    public function postEditShow($post_ID)
    {

        if (!$_SESSION['user_id'])
        {
            $this -> showPage ('Error404View');
            return;
        }
        $connect = new PostDBModel;
        $connect_u = new UserDBModel;
        $post = $connect -> getForIDPost($post_ID);
        if (!(($post['Author'] == $this -> getUserInfo($_SESSION['user_id'])['Login']) || ($this -> getUserInfo($_SESSION['user_id'])['Accessslvl'] == 'admin')))
        {
            $this -> showPage ('Error404View');
            return;
        }
        
        $data_for_view ['post'] = $post;
        $this -> showPage ('PostEditView',$data_for_view );
    }

    public function postEditDelete($post_ID)
    {
        if (!$_SESSION['user_id'])
        {
            $this -> showPage ('Error404View');
            return;
        }

        $connect = new PostDBModel;
        $connect -> deletePost($post_ID);
        $data_for_view["message"] = "Success";
        $this -> showPage ('MainpageView');
    }
    
    public function postEditSave($post_ID)
    {
        if (!$_SESSION['user_id'])
        {
            $this -> showPage ('Error404View');
            return;
        }
        
        $connect = new PostDBModel;
        $post = $connect -> getForIDPost($post_ID);
        
        if (!(($post['Author'] == $this -> getUserInfo($_SESSION['user_id'])['Login']) || ($this -> getUserInfo($_SESSION['user_id'])['Accessslvl'] == 'admin')))
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
                'author' => $this -> getUserInfo($_SESSION['user_id'])['Login'],
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
        if (!isset($_SESSION['is_login']))
            if ($this -> getUserInfo($_SESSION['user_id'])['Accesslvl'] == 'reader')
            {
                $this -> showPage('Error404View');
                return;
            }
        $data_for_view['user'] = $this -> getUserInfo($_SESSION['user_id']);
        $this -> showPage ('BlogCreateView', $data_for_view);
    }

    public function createPost()
    {
        if (!isset($_SESSION['is_login']))
            if ($this -> getUserInfo($_SESSION['user_id'])['Accesslvl'] == 'reader')
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
                'author' => $this -> getUserInfo($_SESSION['user_id'])['Login'],
                'text' => $text,
                'image' => 'images/'.$image,
                'datepub' => date("y-m-d H:i:s "),
                'status' => $status,
            ];
        if ($connect -> addPost($post))
        {
            $host  = $_SERVER['HTTP_HOST'];
            $page = 'Location: http://'.$host.'/userpage';
            header($page);
        }
        else {
            $error_message = 'Unknown error';
            $data_for_view ['error_message'] = $error_message;
            $this -> showPage ('BlogCreateView', $data_for_view);
        }
    }

    public function showUserBlog()
    {
        if (!isset($_SESSION['user_id']))
            {
                $this -> showPage('Error404View');
                return;
            }

        $connect = new PostDBModel;
        $userposts = $connect -> getForLoginPost($this -> getUserInfo($_SESSION['user_id'])['Login']);
        $data_for_view['userposts'] = $userposts;
        $data_for_view['user'] = $this -> getUserInfo($_SESSION['user_id']);
        $this -> showPage ('UserBlogView',$data_for_view);
    }

    public function search()
    {
        $connect_post = new PostDBModel;
        $connect_user = new UserDBModel;
        $_GET['query'] = str_replace('+',' ',$_GET['query']);
        $query = $_GET['query'];
        
        if (isset($_GET['users']))$data_for_view['users'] = true;
        else $data_for_view['users'] = false;
        
        if (isset($_GET['posts']))$data_for_view['posts'] = true;
        else $data_for_view['posts'] = false;
        
        if ($query)
        {
            $posts = $connect_post -> getForQuery($query);
            $acc_posts = array();
            foreach ($posts as $post)
            {
                if (!isset($_SESSION['user_id']))
                {
                    if ($post['Status'] === 'published')
                        $acc_posts[] = $post;
                }
                else
                if (($post['Author'] === $this -> getUserInfo($_SESSION['user_id'])['Login']) || ($post['Status'] === 'published'))
                    $acc_posts[] = $post;
            }
            $authors = $connect_user -> getForQuery($query);
            $data_for_view['found_post'] = $acc_posts;
            $data_for_view['found_author'] = $authors;
        }
        else {
            $data_for_view['found_post'] = false;
            $data_for_view['found_author'] = false;
        }
        $this -> showPage ('SearchResultView', $data_for_view);
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
                'comments' => $comments,
            ];
        if (isset($_SESSION['user_id']))$data_for_view['user'] = $this -> getUserInfo($_SESSION['user_id']);
        $this -> showPage ('FullPostView', $data_for_view);
    }

    public function showMainPage()
    {
        $page_number = 0;
        $from = 0;
        $to = 10;
        $connect = new PostDBModel;
        $all_posts  = $connect -> getFromToPosts($from, $to);
        $data_for_view ['all_posts'] = $all_posts;
        $amount_posts  = $connect -> getAmountRows();
        $amount_pages = $amount_posts / 10;
        $amount_pages = ceil ($amount_pages);
        $data_for_view ['amount_pages'] = $amount_pages;
        $data_for_view ['current_page'] = $page_number;
        if (isset($_SESSION['user_id'])) $data_for_view['user'] = $this -> getUserInfo($_SESSION['user_id']);
        $this -> showPage ('MainpageView', $data_for_view);
    }

    public function showNPage($page_number)
    {
        $page_number --;
        $connect = new PostDBModel;
        $from = 10 * $page_number;
        $to = $from + 10;
        $all_posts = $connect -> getFromToPosts($from, $to);
        $data_for_view['all_posts'] = $all_posts;
        $amount_posts  = $connect -> getAmountRows();
        $amount_pages = $amount_posts / 10;
        $amount_pages = ceil ($amount_pages);
        $data_for_view ['amount_pages'] = $amount_pages;
        $data_for_view ['current_page'] = $page_number;
        if (isset($_SESSION['user_id'])) $data_for_view['user'] = $this -> getUserInfo($_SESSION['user_id']);
        $this -> showPage ('MainpageView', $data_for_view);
    }
    
}