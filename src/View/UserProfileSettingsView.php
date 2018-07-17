<body>
<div class=content>
    <form action="edituser" method="post" name="edit_form">

            <div class="form-group">
                <h3> Your Login: </h3>
                <h2><?php echo $data_for_view['user']['Login'] ?><br>
                </h2>
            </div>

            <div class="form-group">
                <h3> Username:</h3>
                <input type="text" name="n_username" placeholder= <?php echo $data_for_view['user']['Username'] ?>><br>
            </div>

            <div class="form-group">
                <h3>New password:</h3>
                <input type="password" name="n_pass" placeholder="New password"><br>
            </div>

            <div class="form-group">
                <h3>Current password:</h3>
                <input type="password" name="c_pass" placeholder="Current password" required><br>
            </div>

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
</div>
</body>
