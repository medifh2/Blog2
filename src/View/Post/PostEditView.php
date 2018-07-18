<form class="content" method="post" enctype="multipart/form-data" action="/posteditsave/<?php echo $data_for_view ['post']['ID'] ?>">
    <input type="text" name="title" value= <?php echo $data_for_view ['post']['Title'] ?> />
    <br>
    <input type="hidden" name="size" value="30000"/>
    <input type="file" name="image" />

    <?php if (Control\BlogController::hasImage($data_for_view ['post'])):?>
        last picture: <img class='example' src=<?php echo $data_for_view ['post']['Image'] ?>>
    <?php endif; ?>
    <br>
    <textarea title='Your post' name='text' cols="60" rows="15"><?php echo $data_for_view ['post']['Text'] ?></textarea>
    <br>
    Publish: <input title="status" type="checkbox" name="status"
        <?php if (Control\BlogController::isPublish($data_for_view ['post'])) : ?>
            checked
        <?php endif; ?>
    >
    <br><br>
    <button class="btn btn-success" type="submit"> Save</button>
</form>
<form class="bonus" method="post" action="/posteditdelete/<?php echo $data_for_view ['post']['ID'] ?>">
    <button class="btn btn-danger" type="submit"> Delete post</button>
</form>
