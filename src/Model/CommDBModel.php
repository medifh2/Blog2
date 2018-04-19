<?php
namespace Model;

class CommDBModel extends DBModel
{

    function addComment($comment)
    {
        if (!($this -> pdo)) return false;
        $pdo = $this -> pdo;
        $st_insert = $pdo -> prepare("INSERT INTO Blog.comments
        (PostID, Author, Text, DatePub)
        VALUES (:postID, :author, :text, :datepub)");
        $st_insert -> bindParam(':postID', $comment['postID']);
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

    function getForPostIDComment($post_ID)
    {
        $pdo = $this -> pdo;
        $st = $pdo -> prepare ('SELECT * FROM Blog.comments WHERE (PostID = :post_ID)');
        $st -> bindParam(':post_ID', $post_ID);
        $st -> execute();
        $res = $st -> fetchAll();
        return $res;
    }
}