<!DOCTYPE html>

<html>
<body>

<form class="form" action = "edituser" method = "post" name = "edit_form">
    <h6 class = 'error'>
        <?php if (isset($data_for_view['error_message'])) 
            echo $data_for_view['error_message'].'<br>';
        $data_for_view['error_message'] = 0;
        ?>
    </h6>
    <ul>
        
        <li>
            <label >Your Login:</label>
            <label><?php echo $_SESSION['userdata']['login'] ?></label><br>
        </li>
        
        <li>
            <label for = "n_username">Username:</label>
            <input type = "text" name = "n_username" placeholder = <?php echo $_SESSION['userdata']['username'] ?>  ><br>
        </li>

        <li>
            <label for = "n_pass">New password:</label>
            <input type = "password" name = "n_pass" placeholder = "New password"  ><br>
        </li>

        <li>
            <label for = "c_pass">Current password: </label>
            <input type = "password" name = "c_pass" placeholder = "Current password" required ><br>
        </li>

        <li>
            <label for = "n_about">About me:</label>
            <textarea name = "n_about" title = "n_about" ><?php
                if (isset($_POST['n_about'])) {
                    echo $_POST['n_about'];
                    }
                else echo $_SESSION['userdata']['about_me']
                ?></textarea><br>
        </li>

        <li>
            <button class = "submit" type = "submit">Save changes</button>
        </li>

    </ul>
</form>
</body>
</html>