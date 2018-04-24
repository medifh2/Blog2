<!DOCTYPE html>

<html>
<body>
<div class = "fullpost">

    <h6 class = 'success'>
    <?php if (isset($data_for_view['message']))
        echo $data_for_view['message']."<br>";
    $data_for_view['message'] = 0;
    ?>

    </h6>

            <h2> <?php echo $data_for_view['post']['Title'] ?> </h2>
            <h5 class = "comment"> <?php echo $data_for_view['post']['Author'].",  ".$data_for_view['post']['DatePub'] ?> </h5>
            <h4> <?php echo $data_for_view['post']['Text'] ?> </h4>
            <?php
            if ($data_for_view['post']['Image'] !== 'images/') echo "<img class = 'full' src = '{$data_for_view['post']['Image']}'>"
            ?>

    <div class = "comment">
    <h3> Comments:</h3>
    <?php
    if ($data_for_view['comments']) foreach ($data_for_view['comments'] as $comment)
    {?>

        <h5 class = "comment"> <?php echo $comment['Author'].",  ".$comment['DatePub'] ?> </h5>
        <h4> <?php echo $comment['Text'] ?> </h4>

    <?php } ?>
</div>

</div>
<div>
    <h3> Add new comment:</h3>
    <form action = "/createcomment/<?php echo $data_for_view['post']['ID'] ?>" method = "post" name = "comment">
        <textarea title = "Your comment" name = "text" ></textarea><br>
        <button class = "submit" type = "submit">Add comment</button>
    </form>
</div>


</body>
</html>