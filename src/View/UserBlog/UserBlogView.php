<div class = "content">
    <?php if (Control\UserController::hasPostCreatingRights()):?>
        <h4><a  href = "blogcreate"> Create new post </a> </h4>
    <?php endif; ?>
    <h1>My posts:</h1>

<?php View\View::attachUnit("FeedView", $data_for_view); ?>
</div>
