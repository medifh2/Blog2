<?php
namespace Control;

use Model\CommDBModel;
use Model\PostDBModel;
use Model\UserDBModel;
class CommentController extends Controller
{

    public function commentEditShow($comment_ID)
    {

        if (!isset($_SESSION['user_id']))
        {
            $this -> showPage ('Error404View');
            return;
        }
        $connect = new CommDBModel;
        $comment = $connect -> getForIDComment($comment_ID);
        if (!(($comment['Author'] == $this -> getUserInfo($_SESSION['user_id'])['Login']) || ($this -> getUserInfo($_SESSION['user_id'])['Accesslvl'] == 'admin')))
        {
            $this -> showPage ('Error404View');
            return;
        }

        $data_for_view ['comment'] = $comment;
        $this -> showPage ('CommentEditView',$data_for_view );
    }

    public function commentEditSave($comment_ID)
    {
        if (!isset($_SESSION['user_id']))
        {
            $this -> showPage ('Error404View');
            return;
        }

        $connect = new CommDBModel;
        $connect_u = new UserDBModel;
        $comment = $connect -> getForIDComment($comment_ID);

        if (!(($comment['Author'] == $this -> getUserInfo($_SESSION['user_id'])['Login']) || ($this -> getUserInfo($_SESSION['user_id'])['Accesslvl'] == 'admin')))
        {
            $this -> showPage ('Error404View');
            return;
        }

        if (!isset($_POST["text"]))
        {
            $data_for_view ['comment'] = $comment;
            $error_message = 'Wrong Data';
            $data_for_view['error_message'] = $error_message;
            $this -> showPage ('CommentEditView', $data_for_view);
            return;
        }

        if (isset ($_POST['text']))
        {
            $text = $_POST['text'];
        }
        else $text = "";

        $comment =
            [
                'author' => $this -> getUserInfo($_SESSION['user_id'])['Login'],
                'text' => $text,
                'datepub' => date("y-m-d H:i:s "),
                'comment_ID'=> $comment_ID
            ];
        if ($connect -> editComment($comment))
        {
            $post_ID = $connect -> getForIDComment($comment_ID)['PostID'];
            $host  = $_SERVER['HTTP_HOST'];
            $route = 'Location: http://'.$host.'/post/'.$post_ID;
            header($route);
        }
        else {
            $comment = $connect -> getForIDComment($comment_ID);
            $data_for_view ['comment'] = $comment;
            $error_message = 'Unknown error';
            $data_for_view ['error_message'] = $error_message;
            $this -> showPage ('CommentEditView', $data_for_view);
        }
    }

    public function createComment($post_ID)
    {
        $connect_post = new PostDBModel;
        $connect_comm = new CommDBModel;
        if (!isset($_POST["text"]))
        {
            $error_message = 'Empty comment';
            $data_for_view['error_message'] = $error_message;
            $this -> showPage ('FullPostView');
            return;
        }
        else $error_message = false;
        $post = $connect_post -> getForIDPost($post_ID);

        $comment =
            [
                'post_ID' => $post_ID,
                'author' => $post['Author'],
                'text' => $text = $_POST['text'],
                'datepub' => date("y-m-d H:i:s ")
            ];
        print_r($comment);
        $connect_comm -> addComment($comment);
        $host  = $_SERVER['HTTP_HOST'];
        $route = 'Location: http://'.$host.'/post/'.$post_ID;
        header($route);
        $this -> showPage ('UserProfileView');
    }

    public function commentEditDelete($comment_ID)
    {
        if (!isset($_SESSION['user_id']))
        {
            $this -> showPage ('Error404View');
            return;
        }
        $connect = new CommDBModel;
        $post_ID = $connect -> getForIDComment($comment_ID)['PostID'];
        $connect -> deleteComment($comment_ID);
        $date_for_view['message'] = 'Sucsess';
        $host  = $_SERVER['HTTP_HOST'];
        $page = 'Location: http://'.$host.'/post/'.$post_ID;
        header($page);
    }

}