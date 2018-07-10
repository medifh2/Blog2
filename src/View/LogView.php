<!DOCTYPE html>

<html>
<form class="form" method = "post" action = "login">
    <h6 class = 'error'>
    <?php if (isset($data_for_view['error_message']))
    {
        echo $data_for_view['error_message']."<br>";
        unset ($data_for_view['error_message']);
    }
    ?>
    </h6>
    <ul>
        <li>
            <h3>Login</h3><br>
            </li>
        <li>
            <input type = "text" name = "login" placeholder="Login" required/>
        </li>
        <li>
            <input type = "password" name = "pass" placeholder="Password"  required/>
        </li>
        <li>
            <button class = "submit" type = "submit">Enter</button>
        </li>
    </ul>
</form>
</html>
