<!DOCTYPE html>
<html>
<body>
<form class = "content" method = "post" action = "/posteditsave/<?php echo $data_for_view ['post']['ID'] ?>">
   
    <h6 class = 'error'>
        <?php if (isset($data_for_view['error_message']))
            echo $data_for_view['error_message']."<br>";
        $data_for_view['error_message'] = 0;
        ?>
    </h6>
    
    <input type = "text" name = "title" value = <?php echo $data_for_view ['post']['Title'] ?>  >
    <br>
    <input type = "hidden" name = "size" value = "30000" />
    <input type = "file" name = "image" value = <?php echo $data_for_view ['post']['Image'] ?> />
    <?php
    if ($data_for_view ['post']['Image'] !== 'images/') echo "last picture: <img class = 'example' src = '/{$data_for_view ['post']['Image']}'>"
    ?>
    <br>
    <textarea title = 'Your post' name = 'text' cols = "60" rows = "15"><?php echo $data_for_view ['post']['Text'] ?></textarea>
    <br>
    Publish: <input title = "status"  type = "checkbox" name = "status"
        <?php if ($data_for_view ['post']['Status'] == 'published') { ?>
            checked
        <?php } ?>
    >
    <br><br>
    <button class = "submit" type = "submit"> Save </button>
</form>
<form class = "bonus" method = "post" action = "/posteditdelete/<?php echo $data_for_view ['post']['ID'] ?>">
    <button class = "submitdelete" type = "submit"> Delete post </button>
</form>
</body>
</html>