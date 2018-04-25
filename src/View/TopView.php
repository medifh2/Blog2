<!DOCTYPE html>

<html>
<head>
    <title>Blog</title>
    <meta charset = "utf-8">
    <link rel="stylesheet" type="text/css" href="/src/View/styles/styles.css">
</head>

<nav>
    <img class = 'logo' src = '/images/logo/<?php echo $data_for_view['logo'] ?>'>
    <P class = "menu">
        <a  href = "/"> Blog feed </a> | <a href = "/registration"> Registration </a>| <a href = "/login"> Login </a>
        <br>
    <form class = "search" method = "post" action = "/searching">
        <input type = "text" name = "query" />
        <button class = "submit" type="submit">Search</button>
        <br><br>
        Posts:<input title = "status"  type = "checkbox" name = "posts" checked>
        Users:<input title = "status"  type = "checkbox" name = "users" >
    </form>
</nav>
</html>
