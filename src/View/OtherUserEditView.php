<!DOCTYPE html>

<html>
<body>

<form class = "content" action = "/otherusereditsave/<?php echo $data_for_view ['other_user_data']['ID']?>" method = "post" >
    <h6 class = 'error'>
        <?php if (isset($data_for_view['error_message']))
            echo $data_for_view['error_message'].'<br>';
        $data_for_view['error_message'] = 0;
        ?>
    </h6>
    Date of registration: <?php echo $data_for_view['other_user_data']['RegDate'] ?>
    <ul>

        <li>
            <label >Login:</label>
            <input type = "text" name = "login" value = <?php echo $data_for_view['other_user_data']['Login'] ?> >
        </li>

        <li>
            <label for = "n_username">Username:</label>
            <input type = "text" name = "username" value = <?php echo $data_for_view['other_user_data']['Username'] ?>  ><br>
        </li>

        <li>
            <label for = "lvl">Access lvl:</label>
            <input type = "text" name = "lvl" value = <?php echo $data_for_view['other_user_data']['Accesslvl'] ?>  ><br>
        </li>

        <li>
            <label for = "n_about">About me:</label>
            <textarea name = "n_about" title = "n_about" ><?php
                if (isset($_POST['about'])) {
                    echo $_POST['about'];
                }
                else echo $data_for_view['about_me']
                ?></textarea><br>
        </li>
    </ul>
    <button class = "submit" type = "submit">Save changes</button>
</form>
<form class = "bonus" method = "post" action = "/otherusereditdelete/<?php echo $data_for_view ['other_user_data']['ID'] ?>">
    <button class = "submitdelete" type = "submit"> Delete user </button>
</form>
<?php if (!$data_for_view ['other_user_data']['Status']) {?>
<form class = "bonus" method = "post" action = "/otherusereditban/<?php echo $data_for_view ['other_user_data']['ID'] ?>">
    <button class = "submitdelete" type = "submit"> Ban user </button>
</form>
<?php } else {?>
<form class = "bonus" method = "post" action = "/otherusereditunban/<?php echo $data_for_view ['other_user_data']['ID'] ?>">
    <button class = "submitdelete" type = "submit"> Unban user </button>
</form>
<?php } ?>
</body>
</html>