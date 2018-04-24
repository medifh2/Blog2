<!DOCTYPE html>

<html>
<body>

    <h6 class = 'error'>
        <?php if (isset($data_for_view['error_message']))
            echo $data_for_view['error_message'].'<br>';
        $data_for_view['error_message'] = 0;
        ?>
    </h6>
        <table class = "users">
            <tr>
                <th>ID</th>
                <th>Login</th>
                <th>Username</th>
                <th>About me</th>
                <th>Access</th>
                <th>Date of registration</th>
            </tr>
            <?php foreach ($data_for_view['all_users'] as $user)
            { ?>
                <tr>
                    <th>
                        <?php echo $user['ID'] ?>
                    </th>
                    <th>
                        <input type = "text" name = "login:<?php echo $user['ID'] ?>" placeholder = <?php echo $user['Login'] ?> >
                    </th>
                    <th>
                        <input type = "text" name = "username:<?php echo $user['ID'] ?>" placeholder = <?php echo $user['Username'] ?> >
                    </th>
                    <th>
                        <input type = "text" name = "about:<?php echo $user['ID'] ?>" placeholder = <?php echo $user['About_me'] ?> >
                    </th>
                    <th>
                        <input type = "text" name = "lvl:<?php echo $user['ID'] ?>" placeholder = <?php echo $user['Accesslvl'] ?> >
                    </th>
                    <th>
                        <input type = "text" name = "reg_date:<?php echo $user['ID'] ?>" placeholder = <?php echo $user['RegDate'] ?> >
                    </th>
                </tr>
            <?php } ?>
        </table>
</body>
</html>