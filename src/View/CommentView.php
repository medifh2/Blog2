<h5>
    <?php echo $data_for_view['comment']['Author'] . ",  " . $data_for_view['comment']['DatePub'] ?>
    <?php if (Control\UserController::HasEditRights($data_for_view['comment'])) : ?>
        <a class="editcomment" href="/commentedit/<?php echo $data_for_view['comment']['ID'] ?>"> [edit] </a>
    <?php endif; ?>
</h5>
<h4><?php echo $data_for_view['comment']['Text'] ?></h4>