<div class="fullpost">

        <?php View\View::attachUnit("PostView", $data_for_view); ?>

        <div class="comment">
            <h3> Comments:</h3>
            <?php
            if (isset($data_for_view['comments'])) : ?>
                <?php foreach ($data_for_view['comments'] as $data_for_view['comment']) : ?>
                    <?php View\View::attachUnit("CommentView", $data_for_view); ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>


        <?php if ((\Control\UserController::isLogged()) && !(\Control\UserController::isBanned())) : ?>
            <div>
                <h3> Add new comment:</h3>
                <form action="/createcomment/<?php echo $data_for_view['post']['ID'] ?>" method="post" name="comment">
                    <textarea title="Your comment" name="text"></textarea><br>
                    <button class="btn btn-primary" type="submit">Add comment</button>
                </form>
            </div>
        <?php endif; ?>

</div>

