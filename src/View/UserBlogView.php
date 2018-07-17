<!DOCTYPE html>

<html>

<body>
<div class = "content">
    <?php if (($data_for_view['user']['Accesslvl'] === 'writer') || ($data_for_view['user']['Accesslvl'] === 'admin')):?>
        <h4><a  href = "blogcreate"> Create new post </a> </h4>
    <?php endif; ?>
    <h1>My posts:</h1>


<?php include "FeedView.php"; ?>

</div>
</body>
</html>