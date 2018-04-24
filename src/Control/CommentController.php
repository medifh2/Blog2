<?php
namespace Control;

use View\View;
use Model\CommDBModel;
use Model\PostDBModel;

class CommentController extends Controller
{
    

    public function createComment($post_ID)
    {
        echo '-------------------'.$post_ID;
        $connect_post = new PostDBModel;
        $connect_comm = new CommDBModel;
        if (!isset($_POST["text"]))
        {
            $error_message = 'Empty comment';
            $data_for_view['error_message'] = $error_message;
            View::pageGenerate ('FullPostView');
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
        $route = 'Location: http://192.168.33.10/post/'.$post_ID;

        header($route);
    }

}