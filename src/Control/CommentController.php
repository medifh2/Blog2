<?php
namespace Control;

use View\View;
use Model\CommDBModel;

class CommentController extends Controller
{

    public function createComment()
    {
        $connect = new CommDBModel;
        if (!isset($_POST["text"]))
        {
            $_SESSION['error_message'] = 'Empty comment';
            View::pageGenerate ('FullPostView');
            return;
        }

        $text = $_POST['text'];
        $comment =
            [
                'postID' => $_SESSION["ForFullPost"]["PostID"],
                'author' => $_SESSION['Userdata']['Login'],
                'text' => $text,
                'datepub' => date("y-m-d H:i:s ")
            ];
        $connect -> addComment($comment);
        $_SESSION["Comments"] = $connect -> getForPostIDComment($_SESSION["ForFullPost"]["PostID"]);
        View::pageGenerate ('FullPostView');
    }

}