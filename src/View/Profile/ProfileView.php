<div class="content">
<h1><?php echo($data_for_view['user']['Username']) ?></h1>
<h3><?php echo($data_for_view['user']['Accesslvl']) ?><br>
    About <?php echo($data_for_view['user']['Username']) ?>
    : <?php echo ' ' . ($data_for_view['user']['About_me']) ?><br>
</h3>
<?php if (Control\UserController::hasEditProfileRights($data_for_view['user']['ID'])): ?>
    <h4><a href="/settings"> Edit </a></h4>
<?php endif; ?>
</div>