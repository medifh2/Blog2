<div class="content">
    <?php if (!(($data_for_view['is_users_check']) || ($data_for_view['is_posts_check']))) : ?>
        <h6 class="error"> Please select Users or Post filter for searching </h6>
    <?php endif; ?>
    <?php if ($data_for_view['is_users_check']) : ?>
        <h2> Found users: </h2>
        <?php if ($data_for_view['found_author']) : ?>
            <?php foreach ($data_for_view['found_author'] as $author) : ?>
                <a href="user/<?php echo $author['ID'] ?> "> <?php echo $author['Username'] . ' (' . $author['Login'] . ')' ?> </a>
            <?php endforeach; ?>
        <?php else: ?>
            Users not found
        <?php endif; ?>
    <?php endif; ?>
    <?php if ($data_for_view['is_posts_check']) : ?>
        <h2> Found posts: </h2>
        <?php if ($data_for_view['posts']) : ?>
            <?php View\View::attachUnit("FeedView", $data_for_view); ?>
        <?php else: ?>
            <div> Posts not found</div>
        <?php endif; ?>
    <?php endif; ?>
</div>


