<!DOCTYPE html>

<html>

<body>

<form class = "content">

    <?php if ($_SESSION['message'])
        echo $_SESSION['message']."<br>";
    $_SESSION['message'] = 0;
    ?>

    <h1>Main page</h1>
    <?php
    foreach ($_SESSION['Allposts'] as $post)
    {?>

        <div class = "content">

            <h2> <?php echo $post['Title'] ?> </h2>
            <?php echo $post['Author'].",  ".$post['DatePub'] ?>
            <h4> <?php echo $post['Text'] ?> </h4>
            <?php
                if ($post['Image'] !== 'images/') echo "<img class = 'content' src = '{$post['Image']}'>"
            ?>
            <br>

            <form class="form" method = "post" action = "fullpost">
                <input type = "hidden" name = "id" value = <?php echo $post['ID']?> >
                <button class="submit" type="submit">Full</button>
            </form>

        </div>

    <?php   } ?>
    <?php if ($_SESSION['Islast']) echo "<a  href = 'more'> More </a>" ?>
</form>

</body>

</html>