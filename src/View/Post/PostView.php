<h2> <?php echo $data_for_view['post']['Title'] ?> </h2>
<h5>
    <?php echo $data_for_view['post']['Status'] ?>
    <br>
    <?php echo Control\UserController::getNameForID($data_for_view['post']['Author']) . ",  " . $data_for_view['post']['DatePub'] ?>
</h5>
<h4> <?php echo $data_for_view['post']['Text'] ?> </h4>
<?php if (Control\BlogController::hasImage($data_for_view ['post'])) : ?>
    <img src=<?php echo $data_for_view['post']['Image'] ?>>
<?php endif; ?>
<br>
<?php if (Control\UserController::hasEditPostRights($data_for_view['post'])) : ?>
    <a class="edit" href="/postedit/<?php echo $data_for_view['post']['ID'] ?>"> [edit] </a>
    <?php endif ?>

