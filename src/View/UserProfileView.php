<!DOCTYPE html>

<html>
    <body>



    <form class = "content">

        <h6 class = "success">
        <?php if (isset($data_for_view['message']))
            echo $data_for_view['message']."<br>";
        $data_for_view['message'] = 0;
        ?>
        </h6>

        <h1><?php echo ($_SESSION['userdata']['username']) ?></h1>
        <h3><?php echo ($_SESSION['userdata']['lvl']) ?><br>
        About <?php echo ($_SESSION['userdata']['username']) ?>: <?php echo ' '.($_SESSION['userdata']['about_me']) ?><br>
        </h3>
        <h4><a  href = "/settings"> Edit </a> </h4>

    </form>
    </body>
</html>