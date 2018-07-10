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
    if ($data_for_view['post']['Image'] !== 'images/') echo "<img class = 'full' src = '/{$data_for_view['post']['Image']}'>"
    ?>
    <?php if (isset($_SESSION['user_id'])) if (($data_for_view['post']['Author'] == $data_for_view['user']['Login']) || ($data_for_view['user']['Accesslvl'] == 'admin')) {?>
        <a  class = "edit" href = "/postedit/<?php echo $data_for_view['post']['ID'] ?>" > [edit] </a>
    <?php } ?>

    <div class = "comment">
    <h3> Comments:</h3>
    <?php
    if ($data_for_view['comments']) foreach ($data_for_view['comments'] as $comment)
    {?>

        <h5
            class = "comment"> <?php echo $comment['Author'].",  ".$comment['DatePub'] ?>
            <?php if ($_SESSION['user_id']) if (($comment['Author'] == $data_for_view['user']['Login']) || ($data_for_view['user']['Accesslvl']  == 'admin')) {?>
                <a  class = "editcomment" href = "/commentedit/<?php echo $comment['ID'] ?>" > [edit] </a>
            <?php } ?></h5>
        <h4><?php echo $comment['Text'] ?></h4>

    <?php } ?>
</div>

</div>
<?php if (isset($_SESSION['user_id']) && $data_for_view['user']['Status']  !==  'banned') { ?>
<div>
    <h3> Add new comment:</h3>
    <form action = "/createcomment/<?php echo $data_for_view['post']['ID'] ?>" method = "post" name = "comment">
        <textarea title = "Your comment" name = "text" ></textarea><br>
        <button class = "submit" type = "submit">Add comment</button>
    </form>
</div>
<?php } ?>

</body>
</html>