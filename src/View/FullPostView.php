<!DOCTYPE html>

<html>

<body>
<div class = "fullpost">

    <h6 class = 'success'>
    <?php if ($_SESSION['message'])
        echo $_SESSION['message']."<br>";
    $_SESSION['message'] = 0;
    ?>
    </h6>

            <h2> <?php echo $_SESSION["ForFullPost"]['Title'] ?> </h2>
            <h5 class = "comment"> <?php echo $_SESSION["ForFullPost"]['Author'].",  ".$_SESSION["ForFullPost"]['DatePub'] ?> </h5>
            <h4> <?php echo $_SESSION["ForFullPost"]['Text'] ?> </h4>
            <?php
            if ($_SESSION["ForFullPost"]['Image'] !== 'images/') echo "<img class = 'full' src = '{$_SESSION["ForFullPost"]['Image']}'>"
            ?>

    <div class = "comment">
    <h3> Comments:</h3>
    <?php
    if ($_SESSION['Comments']) foreach ($_SESSION['Comments'] as $comment)
    {?>

        <h5 class = "comment"> <?php echo $comment['Author'].",  ".$comment['DatePub'] ?> </h5>
        <h4> <?php echo $comment['Text'] ?> </h4>

    <?php } ?>
</div>

</div>
<div>
    <h3> Add new comment:</h3>
    <form action = "createcomment" method = "post" name = "comment">
        <textarea title = "Your comment" name = "text" ></textarea><br>
        <button class = "submit" type = "submit">Add comment</button>
    </form>
</div>


</body>

</html>