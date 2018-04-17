<!DOCTYPE html>

<html>

<body>
<div class = "fullpost">

    <?php if ($_SESSION['message'])
        echo $_SESSION['message']."<br>";
    $_SESSION['message'] = 0;
    ?>

            <h2> <?php echo $_SESSION["ForFullPost"]['Title'] ?> </h2>
            <h5> <?php echo $_SESSION["ForFullPost"]['Author'].",  ".$_SESSION["ForFullPost"]['DatePub'] ?> </h5>
            <h4> <?php echo $_SESSION["ForFullPost"]['Text'] ?> </h4>
            <?php
            if ($_SESSION["ForFullPost"]['Image'] !== 'images/') echo "<img class = 'full' src = '{$_SESSION["ForFullPost"]['Image']}'>"
            ?>
    <form action = "/edituser" method = "post" name = "edit_form">
        <textarea name = "n_about" >

        </textarea><br>
        <button class = "submit" type = "submit">Add comment</button>
    </form>

</div>
</body>

</html>