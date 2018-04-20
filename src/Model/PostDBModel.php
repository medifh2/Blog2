<?php
namespace Model;

class PostDBModel extends DBModel
{

    function addPost($post)
    {
        if (!($this -> pdo)) return false;
        $pdo = $this -> pdo;
        $st_insert = $pdo -> prepare("INSERT INTO Blog.posts 
        (Text, Image, Author, Title, DatePub, Status) 
        VALUES (:text, :image, :author, :title, :datepub, :status)");
        $st_insert -> bindParam(':text', $post['text']);
        $st_insert -> bindParam(':image', $post['image']);
        $st_insert -> bindParam(':author', $post['author']);
        $st_insert -> bindParam(':title', $post['title']);
        $st_insert -> bindParam(':datepub', $post['datepub']);
        $st_insert -> bindParam(':status', $post['status']);
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

    function getForDataPost($login_arr, $date_from, $date_to, $title)
    {

        $pdo = $this -> pdo;
        $statement = "SELECT * FROM Blog.posts WHERE (DatePub >= :date_from) AND (DatePub <= :date_to)";
        if ($login_arr ) $statement = $statement . "AND (Author = :login)";
        if ($title ) $statement = $statement . "AND (Title = :title)";
        $statement = $statement . "ORDER BY DatePub Desc";
        $st = $pdo -> prepare($statement);
        if ($login_arr )
        {
            foreach ($login_arr as $login)
            {
                if ($login) $st -> bindParam(':login', $login['Login']);
                if ($title) $st -> bindParam(':title', $title);
                if ($date_from) $st -> bindParam(':date_from', $date_from);
                if ($date_to) $st -> bindParam(':date_to', $date_to);
                $st -> execute();
                $res[$login['Login']] = $st -> fetchAll();
            }
        }
        else {
            if ($title) $st -> bindParam(':title', $title);
            if ($date_from) $st -> bindParam(':date_from', $date_from);
            if ($date_to) $st -> bindParam(':date_to', $date_to);
            $st -> execute();
            $res['0'] = $st -> fetchAll();
        }
        return $res;
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