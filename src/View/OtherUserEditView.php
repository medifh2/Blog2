<body>
<div class=content>
    <form action="/otherusereditsave/<?php echo $data_for_view ['other_user_data']['ID'] ?>" method="post">
        <div class="form-group">
            Date of registration: <br>
            <?php echo $data_for_view['other_user_data']['RegDate'] ?>
            </div>
            <div class="form-group">
                <label>Login:</label>
                <input type="text" name="login" value= <?php echo $data_for_view['other_user_data']['Login'] ?>>
            </div>
            <div class="form-group">
                <label for="n_username">Username:</label>
                <input type="text" name="username"
                       value= <?php echo $data_for_view['other_user_data']['Username'] ?>><br>
            </div>
            <div class="form-group">
                <label for="lvl">Access lvl:</label>
                <input type="text" name="lvl" value= <?php echo $data_for_view['other_user_data']['Accesslvl'] ?>><br>
            </div>
            <div class="form-group">
                <label for="about">About me:</label>
            <textarea name="about" title="about"><?php
                if (isset($_POST['about'])) {
                    echo $_POST['about'];
                } else echo $data_for_view['other_user_data']['About_me']
                ?></textarea><br>
            </div>
            <button class="btn btn-success" type="submit">Save changes</button>
    </form>
    <br>
    <form method="post" action="/otherusereditdelete/<?php echo $data_for_view ['other_user_data']['ID'] ?>">
        <br><button class="btn btn-danger" type="submit"> Delete user</button>
    </form>

    <?php if (!$data_for_view ['other_user_data']['Status']) { ?>
        <form method="post" action="/otherusereditban/<?php echo $data_for_view ['other_user_data']['ID'] ?>">
            <br> <button class="btn btn-danger" type="submit"> Ban user</button>
        </form>
    <?php } else { ?>
        <form method="post" action="/otherusereditunban/<?php echo $data_for_view ['other_user_data']['ID'] ?>">
            <br><button class="btn btn-success" type="submit"> Unban user</button>
        </form>
    <?php } ?>
</div>
</body>
