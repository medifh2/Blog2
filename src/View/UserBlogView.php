<!DOCTYPE html>

<html>

<body>
<div class = "content">

    <?php if (($_SESSION['userdata']['lvl'] === 'writer') || ($_SESSION['userdata']['lvl'] === 'admin'))
        echo '<h4><a  href = "blogcreate"> Create new post </a> </h4>';
    ?>
    <h1>Posts:</h1>

    <?php
        foreach ($data_for_view['userposts'] as $post)
        {?>
</div>
<div class = "put">
    <h2> <?php echo $post['Title'] ?> </h2>
    <h5> <?php echo $post['Author'].",  ".$post['DatePub'] ?> </h5>
    <h6> <?php echo $post['Status'] ?> </h6>
    <h4> <?php echo $post['Text'] ?> </h4>
    <?php
    if ($post['Image'] !== 'images/') echo "<img src = '{$post['Image']}'>"
    ?>
    <br>
    <a  class = "link" href = "post/<?php echo $post['ID'] ?>" type = "submit"> Full </a>
</div>
        <?php   } ?>
    

</body>
</html>