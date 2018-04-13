<!DOCTYPE html>

<html>
<form class="form" method = "post" action = "loguser">
    <?php if ($_SESSION['error_message'])
        echo $_SESSION['error_message']."<br>";
    $_SESSION['error_message'] = 0;
    ?>
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
            <button class="submit" type="submit">Enter</button>
        </li>
    </ul>
</form>
</html>
