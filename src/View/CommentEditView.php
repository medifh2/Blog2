<body>
<form class="content" action="/commenteditsave/<?php echo $data_for_view['comment']['ID'] ?>" method="post"
      name="comment">
    <h5 class="comment"> <?php echo $data_for_view['comment']['Author'] . ",  " . $data_for_view['comment']['DatePub'] ?> </h5>
    <textarea title="Your comment" name="text"><?php echo $data_for_view['comment']['Text'] ?></textarea><br>
    <button type="submit" class="btn btn-success"> Save</button>
</form>
<form class="bonus" method="post" action="/commenteditdelete/<?php echo $data_for_view ['comment']['ID'] ?>">
    <button type="submit" class="btn btn-danger"> Delete comment</button>
</form>
</body>
