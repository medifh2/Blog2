<!DOCTYPE html>

<html>

<body>
<div class = "content">

    <h6 class = 'success'>
        <?php if ($_SESSION['message'])
            echo $_SESSION['message']."<br>";
        $_SESSION['message'] = 0;
        ?>
    </h6>

    <form method = "post" action = "searching" >
        <ul>
            <li>
                <label for = "Author">Author's Login:</label>
                <input type = "text" name = "Author_login" placeholder = "Login"><br>
            </li>
            <li>
                <label for = "Author">Author's Username:</label>
                <input type = "text" name = "Author_username" placeholder = "Username"><br>
            </li>
            <li>
                <label for = "Title">Title:</label>
                <input type = "text" name = "Title" placeholder = "Title"><br>
            </li>
            <li>
                <label for = "Date">Date from:</label>
                <input class = "date" type = "text" name = "From" placeholder = "yyyy-mm-dd hh:mm:ss">
            </li>
            <li>
                <label for = "Date">Date to:</label>
                <input class = "date" type = "text" name = "To" placeholder = "yyyy-mm-dd hh:mm:ss"><br>
            </li>
            <li>
                <button class = "submit" type="submit">Search</button>
            </li>
        </ul>
    </form>
    <h2> Found users: </h2>
    
    <?php foreach ($_SESSION['Found_author'] as $author) { ?>
        <form class="linkauthor" method = "post" action = "linkauthor">
            <?php $_SESSION["OtherUserdata"] = $author; ?>
            <button class = 'linkauthor' type = 'submit'> <?php echo $author['Login'] ?></button>
        </form>
    <?php } ?>
    
    <h2> Found posts: </h2>
    <?php if ($_SESSION['Found_post'])
        foreach ($_SESSION['Found_post'] as $post_arr)
            foreach ($post_arr as $post)
            {?>
                <form class="put" method = "post" action = "fullpost">
                    <h2> <?php echo $post['Title'] ?> </h2>
                    <h5> <?php echo $post['Author'].",  ".$post['DatePub'] ?> </h5>
                    <h4> <?php echo $post['Text'] ?> </h4>
                    <?php
                    if ($post['Image'] !== 'images/') echo "<img src = '{$post['Image']}'>"
                    ?>
                    <br>
                    <input type = "hidden" name = "PostID" value = <?php echo $post['ID'] ?> >
                    <button class = "put" type="submit">Full post</button>
                </form>
            <?php } ?>

</div>
</body>

</html>