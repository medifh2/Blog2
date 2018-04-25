<!DOCTYPE html>
<html>
<body>
<form class = "content" action = "/commenteditsave/<?php echo $data_for_view['comment']['ID'] ?>" method = "post" name = "comment">
<h5 class = "comment"> <?php echo $data_for_view['comment']['Author'].",  ".$data_for_view['comment']['DatePub'] ?> </h5>

    <textarea title = "Your comment" name = "text" ><?php echo $data_for_view['comment']['Text'] ?></textarea><br>
    <button class = "submit" type = "submit">Save</button>
</form>
<form class = "bonus" method = "post" action = "/commenteditdelete/<?php echo $data_for_view ['comment']['ID'] ?>">
    <button class = "submitdelete" type = "submit"> Delete comment </button>
</form>
</body>
</html>