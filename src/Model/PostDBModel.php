<?php
namespace Model;

class PostDBModel extends DBModel
{

    function addPost($post)
    {
        if (!($this -> pdo)) return false;
        $pdo = $this -> pdo;
        $st_insert = $pdo -> prepare("INSERT INTO Blog.posts 
        (Text, Image, Author, Title, DatePub) 
        VALUES (:text, :image, :author, :title, :datepub)");
        $st_insert -> bindParam(':text', $post['text']);
        $st_insert -> bindParam(':image', $post['image']);
        $st_insert -> bindParam(':author', $post['author']);
        $st_insert -> bindParam(':title', $post['title']);
        $st_insert -> bindParam(':datepub', $post['datepub']);
        $st_insert -> execute();
        return true;
    }

    function getForLoginPost($login)
    {
        $pdo = $this -> pdo;
        $st = $pdo -> prepare ('SELECT * FROM Blog.posts WHERE (Author = :login) ORDER BY DatePub Desc');
        $st -> bindParam(':login', $login);
        $st -> execute();
        $res = $st -> fetchAll();
        return $res;
    }

    function getForDataPost($login, $username, $date_from, $date_to)
    {

    }


    function getForIDPost($post_ID)
    {
        $pdo = $this -> pdo;
        $st = $pdo -> prepare ('SELECT * FROM Blog.posts WHERE (ID = :ID)');
        $st -> bindParam(':ID', $post_ID);
        $st -> execute();
        $res = $st -> fetchAll();
        return $res[0];
    }

    function getNumPosts($num)
    {
        $pdo = $this -> pdo;

        $st = $pdo -> prepare ('SELECT * FROM Blog.posts ORDER BY DatePub Desc LIMIT :num');
        $st -> bindParam(':num', $num);

        $st -> execute();
        $res = $st -> fetchAll();
        return $res;
    }
    function getNumRows()
    {
        $pdo = $this -> pdo;
        $st = $pdo -> prepare ('SELECT COUNT(*) FROM Blog.posts');
        $st -> execute();
        $res = $st -> fetchAll();
        return $res[0]['COUNT(*)'];
    }
}