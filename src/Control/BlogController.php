<?php
namespace Control;

use Model\PostDBModel;
use Model\CommDBModel;
use Model\UserDBModel;

class BlogController extends Controller
{

    function __construct()
    {

    }

    public function showEditPost($post_ID)
    {

        $connect = new PostDBModel;
        $post = $connect->getForIDPost($post_ID);
        $data_for_view ['post'] = $post;
        $this->showPage('PostEditView', $data_for_view);
    }

    public function deletePost($post_ID)
    {
        $connect = new PostDBModel;
        $connect->deletePost($post_ID);
        $data_for_view["message"] = "Success";
        $host = $_SERVER['HTTP_HOST'];
        $route = 'Location: http://' . $host . '/';
        header($route);
    }

    public function savePost($post_ID = NULL)
    {
        $page_back = ($post_ID == NULL) ? 'PostCreateView' : 'PostEditView';
        $connect = new PostDBModel;
        if ($post_ID) {
            $post_last = $connect->getForIDPost($post_ID);
            $data_for_view ['post'] = $post_last;

        }

        if ((!isset($_POST["text"]) && !$_FILES['image']['name']) || (!$_POST["title"])) {
            $error_message = 'Wrong Data';
            $data_for_view['error_message'] = $error_message;
            $this->showPage($page_back, $data_for_view);
            return;
        }

        if ($_FILES['image']['name']) {
            $target = "images/" . ($_FILES['image']['name']);
            $image = $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $target);
        } else {
            $image = "";
        }

        $status = (isset($_POST["status"])) ? 'published' : 'unpublished';

        $text = isset($_POST['text']) ? $_POST['text'] : '';

        $post =
            [
                'title' => $_POST["title"],
                'author' => $this->getUserInfo()['Login'],
                'text' => $text,
                'image' => '/images/' . $image,
                'datepub' => date("y-m-d H:i:s "),
                'status' => $status,
                'post_ID' => $post_ID
            ];
        if ($post_ID) {
            $post['post_ID'] = $post_ID;
            if (!$_FILES['image']['name']) {
                $post['image'] = $post_last['Image'];
            }
            $res = $connect->editPost($post);
        } else {
            $res = $connect->addPost($post);
        }
        if ($res) {
            $host = $_SERVER['HTTP_HOST'];
            $route = 'Location: http://' . $host . '/userpage';
            header($route);
        } else {
            $data_for_view ['post'] = $post;
            $error_message = 'Unknown error';
            $data_for_view ['error_message'] = $error_message;
            $this->showPage($page_back, $data_for_view);
        }
    }

    public function showPostCreate()
    {
        $this->showPage('PostCreateView');
    }

    public function showUserBlog($page_number = 1)
    {
        $page_number--;
        $from = 10 * $page_number;
        $to = $from + 10;
        $connect = new PostDBModel;
        $posts = $connect->getFromToForLoginPosts($from, $to, $this->getUserInfo()['Login']);
        $data_for_view ['posts'] = $posts;
        $amount_posts = $connect->getAmountPublishRowsForLogin($this->getUserInfo()['Login']);
        $amount_pages = $amount_posts / 10;
        $amount_pages = ceil($amount_pages);
        $data_for_view ['amount_pages'] = $amount_pages;
        $data_for_view ['current_page'] = $page_number;
        $this->showPage('UserBlogView', $data_for_view);
    }

    public function search()
    {
        $connect_post = new PostDBModel;
        $connect_user = new UserDBModel;
        $_GET['query'] = str_replace('+', ' ', $_GET['query']);
        $query = $_GET['query'];

        $data_for_view['is_users_check'] = isset($_GET['users']);
        $data_for_view['is_posts_check'] = isset($_GET['posts']);
        $data_for_view['query'] = ($query) ? $query : false;

        if ($query) {
            $posts = $connect_post->getForQuery($query);
            $acc_posts = array();
            foreach ($posts as $post) {
                if (!isset($_SESSION['user_id'])) {
                    if ($post['Status'] === 'published')
                        $acc_posts[] = $post;
                } else if (($post['Author'] === $this->getUserInfo()['Login']) || ($post['Status'] === 'published')) {
                    $acc_posts[] = $post;
                }
            }
            $authors = $connect_user->getForQuery($query);
            $data_for_view['posts'] = $acc_posts;
            $data_for_view['found_author'] = $authors;
        } else {
            $data_for_view['posts'] = false;
            $data_for_view['found_author'] = false;
        }
        $this->showPage('SearchResultView', $data_for_view);
    }

    public function showFullPost($route_data)
    {
        if (!$route_data) {
            $this->showPage('Error404View');
            return;
        }
        $post_ID = $route_data;
        $connect_postDB = new PostDBModel;
        $post = $connect_postDB->getForIDPost($post_ID);

        $connect_commDB = new CommDBModel;
        if ($data_for_view['comments'] = $connect_commDB->getForPostIDComment($post_ID)) ;

        $data_for_view =
            [
                'post' => $post,
                'post_ID' => $post_ID,
            ];
        $this->showPage('FullPostView', $data_for_view);
    }

    public function showMainPage($page_number = 1)
    {
        $page_number--;
        $from = 10 * $page_number;
        $to = $from + 10;
        $connect = new PostDBModel;
        $posts = $connect->getFromToPublishPosts($from, $to);
        $data_for_view ['posts'] = $posts;
        $amount_posts = $connect->getAmountPublishRows();
        $amount_pages = $amount_posts / 10;
        $amount_pages = ceil($amount_pages);
        $data_for_view ['amount_pages'] = $amount_pages;
        $data_for_view ['current_page'] = $page_number;
        $this->showPage('MainPageView', $data_for_view);
    }

    public static function hasImage($post)
    {
        return ($post['Image'] !== '/images/');
    }

    public static function isPublish($post)
    {
        return ($post['Status'] == 'published');
    }

}