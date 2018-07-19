<div class=content>
    <form action="/edituser/<?php echo $data_for_view['user']['ID'] ?>" method="post" name="edit_form">
        <div class="form-group">
            <h3> Login: </h3>
            <?php if (Control\UserController::isLoggedAdmin()): ?>
                <input type="text" name="login" value= <?php echo $data_for_view['user']['Login'] ?>>
            <?php else : ?>
                <h2><?php echo $data_for_view['user']['Login'] ?><br></h2>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <h3> Username:</h3>
            <input type="text" name="n_username" placeholder= <?php echo $data_for_view['user']['Username'] ?>><br>
        </div>

        <div class="form-group">
            <h3>New password:</h3>
            <input type="password" name="n_pass" placeholder="New password"><br>
        </div>

        <?php if (!Control\UserController::isLoggedAdmin()) : ?>
            <div class="form-group">
                <h3>Current password:</h3>
                <input type="password" name="c_pass" placeholder="Current password" required><br>
            </div>
        <?php endif; ?>

        <div class="form-group">
            <h3> About me: </h3>
            <textarea name="n_about" title="n_about"><?php
                if (isset($_POST['n_about'])) {
                    echo $_POST['n_about'];
                } else echo $data_for_view['user']['About_me']
                ?></textarea><br>
        </div>

        <button class="btn btn-success" type="submit">Save changes</button>
    </form>
    <br>
    <?php if (Control\UserController::isLoggedAdmin() && !Control\UserController::isUserAdmin($data_for_view['user']['ID'])): ?>

        <form method="post" action="/otherusereditdelete/<?php echo $data_for_view ['user']['ID'] ?>">
            <br>
            <button class="btn btn-danger" type="submit"> Delete user</button>
        </form>

        <?php if (!\Control\UserController::isBanned($data_for_view ['user']['ID'])) : ?>
            <form method="post" action="/userban/<?php echo $data_for_view ['user']['ID'] ?>">
                <br>
                <button class="btn btn-danger" type="submit"> Ban user</button>
            </form>
        <?php else : ?>
            <form method="post" action="/userunban/<?php echo $data_for_view ['user']['ID'] ?>">
                <br>
                <button class="btn btn-success" type="submit"> Unban user</button>
            </form>
        <?php endif; ?>
    <?php endif; ?>
</div>

