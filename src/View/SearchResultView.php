<body>
<div class="content">

    <?php if (!(($data_for_view['is_users_check']) || ($data_for_view['is_posts_check']))) { ?>
        <h6 class="error"> Please select Users or Post filter for searching </h6>
    <?php } ?>
    <?php if ($data_for_view['is_users_check']) { ?>
        <h2> Found users: </h2>
        <?php
        if ($data_for_view['found_author'])
            foreach ($data_for_view['found_author'] as $author) { ?>
                <a href="user/<?php echo $author['ID'] ?> "> <?php echo $author['Username'] . ' (' . $author['Login'] . ')' ?> </a>
            <?php } else echo " Users not found ";
    } ?>

    <?php if ($data_for_view['is_posts_check']) : ?>
        <h2> Found posts: </h2>

        <?php if ($data_for_view['posts']) : ?>
            <?php include "FeedView.php"; ?>
            <?php
        else: echo "<div>  Posts not found </div>"; ?>
        <?php endif; ?>
    <?php endif; ?>
</div>
</body>

