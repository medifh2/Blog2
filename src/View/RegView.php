<!DOCTYPE html>

<html>

<form class="form" method = "post" action = "registration">

    <h6 class = 'error'>
        <?php if (isset($data_for_view['error_message']))
            echo $data_for_view['error_message']."<br>";
        $data_for_view['error_message'] = 0;
        ?>
    </h6>

    <ul>
        <li>
            <h3>Registration</h3><br>
        </li>
        <li>
            <input type = "text" name = "login" placeholder="Login" required/>
        </li>
        <li>
            <input type = "text" name = "username" placeholder="Username"  required/>
        </li>
        <li>
            <input type = "password" name = "pass" placeholder="Password"  required/>
        </li>
        <li>
            <input type = "password" name = "r_pass" placeholder="Repeat password"  required/>
        </li>

        <li>
           <button class="submit" type="submit">Registration</button>
        </li>
    </ul>
</form>
</html>
