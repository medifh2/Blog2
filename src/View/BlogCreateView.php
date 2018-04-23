<!DOCTYPE html>
<html>
<body>
<form enctype="multipart/form-data" class = "content" method = "post" action = "createpost">
    <h6 class = 'error'>
    <?php if (isset($data_for_view['error_message']))
        echo $data_for_view['error_message']."<br>";
    $data_for_view['error_message'] = 0;
    ?>
    </h6>
    <input type = "text" name = "title" placeholder="Title" required/>
    <br>
    <input type="hidden" name="size" value="30000" />
    <input type = "file" name = "image" />
    <br>
    <textarea title = 'Your post' name = 'text' cols = "60" rows = "15"></textarea>
    <br>
    Publish: <input title = "status"  type = "checkbox" name = "status" checked>  <br><br>
    <button class="submit" type="submit">Create</button>
</form>
</body>
</html>