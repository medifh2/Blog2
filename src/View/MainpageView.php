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

    <h1>Main page</h1>

    <?php
    foreach ($_SESSION['Allposts'] as $post)
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
    <?php if ($_SESSION['Islast']) echo "<a  href = 'more'> More </a>" ?>
    </div>
</body>

</html>