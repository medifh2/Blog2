<!DOCTYPE html>

<html>

<body>
<div class = "content">

    <h6 class = 'success'>
        <?php if (isset($data_for_view['message']))
            echo $data_for_view['message']."<br>";
        $data_for_view['message'] = 0;
        ?>
    </h6>

   <!-- <form method = "post" action = "searching" >
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
    -->
    <?php if ($data_for_view['users']) {?>
    <h2> Found users: </h2>
    <?php
    if ($data_for_view['found_author'])
    foreach ($data_for_view['found_author'] as $author) { ?>
            <a  href = "user/<?php echo $author['ID']?> " > <?php echo $author['Username'].' ('.$author['Login'].')' ?> </a>
    <?php } else echo "<div> Users not found </div>"; }?>

    <?php if ($data_for_view['posts']) { ?>
    <h2> Found posts: </h2>
</div>
    <?php
    if ($data_for_view['found_post'])
        foreach ($data_for_view['found_post'] as $post)
            {?>
                <div class="put" >
                    <h2> <?php echo $post['Title'] ?> </h2>
                    <h5> <?php echo $post['Author'].",  ".$post['DatePub'] ?> </h5>
                    <h4> <?php echo $post['Text'] ?> </h4>
                    <?php
                    if ($post['Image'] !== 'images/') echo "<img src = '{$post['Image']}'>"
                    ?>
                    <br>
                    <input type = "hidden" name = "PostID" value = <?php echo $post['ID'] ?> >
                    <button class = "put" type="submit">Full post</button>
                </div>
            <?php } else echo "<div>  Posts not found </div>"; }?>


</body>

</html>