<!DOCTYPE html>

<html>
<form class="content">
    <h1>Main page</h1>
    <?php
    foreach ($_SESSION['Allposts'] as $post)
    {?>
        <div class = "content">
            <h2> <?php echo $post['Title'] ?> </h2>
            <?php echo $post['Author'].",  ".$post['DatePub'] ?>
            <h4><?php echo $post['Text'] ?> </h4>
            <?php if ($post['Image'] !== 'images/') echo "<img src = '{$post['Image']}'>"?>
            <br>
        </div>
    <?php   } ?>
    <?php if ($_SESSION['Islast']) echo "<a  href = 'more'> More </a>" ?>
</form>
</html>