<!DOCTYPE html>

<html>

<body>
<form class="content">

    <?php if (($_SESSION['Userdata']['Lvl'] === 'writer') || ($_SESSION['Userdata']['Lvl'] === 'admin'))
        echo '<h4><a  href = "/blogcreate"> Create new post </a> </h4>';
    ?>
    <h1>Posts:</h1>

    <?php
        foreach ($_SESSION['Userposts'] as $post)
        {?>
            <div class = "content">
                <h2> <?php echo $post['Title'] ?> </h2>
                <?php echo $post['Author'].",  ".$post['DatePub'] ?>
                <h4><?php echo $post['Text'] ?> </h4>
                <?php if ($post['Image'] !== 'images/') echo "<img src = '{$post['Image']}'>"?>
                <br>
                <a  href = 'fullpost'> Full </a>
            </div>
            </>
        <?php   } ?>

</form>
</body>
</html>