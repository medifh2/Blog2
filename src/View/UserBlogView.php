<!DOCTYPE html>

<html>

<body>
<div class = "content">

    <?php if (($_SESSION['Userdata']['Lvl'] === 'writer') || ($_SESSION['Userdata']['Lvl'] === 'admin'))
        echo '<h4><a  href = "blogcreate"> Create new post </a> </h4>';
    ?>
    <h1>Posts:</h1>

    <?php
        foreach ($_SESSION['Userposts'] as $post)
        {?>

            <form class="put" method = "post" action = "fullpost">
                <h2> <?php echo $post['Title'] ?> </h2>
                <h5> <?php echo $post['Author'].",  ".$post['DatePub'] ?> </h5>
                <h6> <?php echo $post['Status'] ?> </h6>
                <h4> <?php echo $post['Text'] ?> </h4>
                <?php
                if ($post['Image'] !== 'images/') echo "<img src = '{$post['Image']}'>"
                ?>
                <br>
                <input type = "hidden" name = "PostID" value = <?php echo $post['ID'] ?> >
                <button class = "link" type="submit">Full post</button>
            </form>
        <?php   } ?>

</div>
</body>
</html>