<?php
namespace Control;

use Model\CommDBModel;
use Model\PostDBModel;
use Model\UserDBModel;

class CommentController extends Controller
{

    public function showEditComment($comment_ID)
    {

        $connect = new CommDBModel;
        $comment = $connect->getForIDComment($comment_ID);

        $data_for_view ['comment'] = $comment;
        $this->showPage('CommentEditView', $data_for_view);
    }

    public function saveEditedComment($comment_ID)
    {
        $connect = new CommDBModel;
        $comment = $connect->getForIDComment($comment_ID);
        
        if (!isset($_POST["text"])) {
            $data_for_view ['comment'] = $comment;
            $error_message = 'Wrong Data';
            $data_for_view['error_message'] = $error_message;
            $this->showPage('CommentEditView', $data_for_view);
            return;
        }

        if (isset ($_POST['text'])) {
            $text = $_POST['text'];
        } else $text = "";

        $comment =
            [
                'author' => $_SESSION['user_id'],
                'text' => $text,
                'datepub' => date("y-m-d H:i:s "),
                'comment_ID' => $comment_ID
            ];
        if ($connect->editComment($comment)) {
            $post_ID = $connect->getForIDComment($comment_ID)['PostID'];
            $this->showURLPage('/post/' . $post_ID);
        } else {
            $comment = $connect->getForIDComment($comment_ID);
            $data_for_view ['comment'] = $comment;
            $error_message = 'Unknown error';
            $data_for_view ['error_message'] = $error_message;
            $this->showPage('CommentEditView', $data_for_view);
        }
    }

    public function createComment($post_ID)
    {
        
        $connect_comm = new CommDBModel;
        if (!isset($_POST["text"])) {
            $error_message = 'Empty comment';
            $data_for_view['error_message'] = $error_message;
            $this->showPage('FullPostView');
            return;
        } 

        $comment =
            [
                'post_ID' => $post_ID,
                'author' => $_SESSION['user_id'],
                'text' => $text = $_POST['text'],
                'datepub' => date("y-m-d H:i:s ")
            ];
        $connect_comm->addComment($comment);
        $this->showURLPage('/post/' . $post_ID);
    }

    public function deleteComment($comment_ID)
    {
        if (!isset($_SESSION['user_id'])) {
            $this->showPage('Error404View');
            return;
        }
        $connect = new CommDBModel;
        $post_ID = $connect->getForIDComment($comment_ID)['PostID'];
        $connect->deleteComment($comment_ID);
        $date_for_view['message'] = 'Sucsess';
        $this->showURLPage('/post/' . $post_ID);
    }
    
}