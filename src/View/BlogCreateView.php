<!DOCTYPE html>
<html>
<body>
<form enctype="multipart/form-data" class = "content" method = "post" action = "createpost">
    <?php if ($_SESSION['error_message'])
        echo $_SESSION['error_message']."<br>";
    $_SESSION['error_message'] = 0;
    ?>
    <input type = "text" name = "title" placeholder="Title" required/>
    <br>
    <input type="hidden" name="size" value="30000" />
    <input type = "file" name = "image" />
    <br>
    <textarea name ='text' cols = "60" rows = "15"></textarea>
    <br>
    <button class="submit" type="submit">Create</button>
</form>
</body>
</html>