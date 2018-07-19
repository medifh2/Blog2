<div class = "content">

    <h1>My posts:</h1>
    <?php if (Control\UserController::hasPostCreatingRights()):?>
        <a  href = "blogcreate"> Create new post </a>
    <?php endif; ?>

<?php View\View::attachUnit("FeedView", $data_for_view); ?>
</div>
