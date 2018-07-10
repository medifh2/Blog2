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
    <form class = "search" method = "GET" action = "/search">
        <input type = "text" name = "query"
            <?php if (isset($_GET['query'])) { ?>
                value = <?php echo $_GET['query']  ?>
            <?php } ?>
        >
        <button class = "submit" type="submit"> Search </button>
        <br><br>
        Posts:
        <input title = "status"  type = "checkbox" name = "posts"
            <?php if (isset($_GET['posts'])||(!isset($_GET['query'])&&(!isset($_GET['users'])))) {?>
                checked
            <?php } ?>
        >
        Users:
        <input title = "status"  type = "checkbox" name = "users"
               <?php if (isset($_GET['users'])) { ?>
                   checked
               <?php }  ?>
        >
    </form>
</nav>
</html>
