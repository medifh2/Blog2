<?php
namespace Model;

class CommDBModel extends DBModel
{

    function addComment($comment)
    {
        $pdo = $this -> pdo;
        $st_insert = $pdo -> prepare("INSERT INTO Blog.comments
        (PostID, Author, Text, DatePub)
        VALUES (:postID, :author, :text, :datepub)");
        $st_insert -> bindParam(':postID', $comment['post_ID']);
        $st_insert -> bindParam(':author', $comment['author']);
        $st_insert -> bindParam(':text', $comment['text']);
        $st_insert -> bindParam(':datepub', $comment['datepub']);
        $st_insert -> execute();
        return true;
    }

    function getForLoginComment($login)
    {
        $pdo = $this -> pdo;
        $st = $pdo -> prepare ('SELECT * FROM Blog.comments WHERE (Author = :login) ORDER BY DatePub Desc');
        $st -> bindParam(':login', $login);
        $st -> execute();
        $res = $st -> fetchAll();
        return $res;
    }

    function getForIDComment($comment_ID)
    {
        $pdo = $this -> pdo;
        $st = $pdo -> prepare ('SELECT * FROM Blog.comments WHERE (ID = :ID)');
        $st -> bindParam(':ID', $comment_ID);
        $st -> execute();
        $res = $st -> fetchAll();
        return $res[0];
    }
    
    function getForPostIDComment($post_ID)
    {
        $pdo = $this -> pdo;
        $st = $pdo -> prepare ('SELECT * FROM Blog.comments WHERE (PostID = :post_ID)');
        $st -> bindParam(':post_ID', $post_ID);
        $st -> execute();
        $res = $st -> fetchAll();
        return $res;
    }

    function editComment($comment)
    {
        $pdo = $this -> pdo;
        $st = $pdo -> prepare ('UPDATE Blog.comments SET Text = :text WHERE (ID = :comment_ID)');
        $st->bindParam(':text', $comment['text']);
        $st->bindParam(':comment_ID', $comment['comment_ID']);
        $st->execute();
        return true;
    }

    function deleteComment($comment_ID)
    {
        $pdo = $this -> pdo;
        $st = $pdo -> prepare('DELETE FROM Blog.comments WHERE ID = :comment_ID');
        $st->bindParam(':comment_ID', $comment_ID);
        $st->execute();
        return true;
    }
}