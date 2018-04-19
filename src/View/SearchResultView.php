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
                <label for = "Date">Date:</label>
                <input class = "date" type = "text" name = "From" placeholder = "yyyy-mm-dd hh:mm:ss">
                -
                <input class = "date" type = "text" name = "To" placeholder = "yyyy-mm-dd hh:mm:ss"><br>
            </li>
            <li>
                <button class = "submit" type="submit">Search</button>
            </li>
        </ul>
    </form>

    <?php if ($_SESSION['Found_author']) echo "<a  href =".$_SESSION['Found_author']."Author </a>" ?>
    <?php if ($_SESSION['Found_post'])
    foreach ($_SESSION['Found_post'] as $post)
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