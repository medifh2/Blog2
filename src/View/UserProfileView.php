<!DOCTYPE html>

<html>
    <body>

    <form class = "content">

        <h6 class = "success">
        <?php if (isset($data_for_view['message']))
        {
            echo $data_for_view['message'] . "<br>";
            unset ($data_for_view['message']);
        }
        ?>
        </h6>

        <h1><?php echo ($data_for_view['user']['Username']) ?></h1>
        <h3><?php echo ($data_for_view['user']['Accesslvl']) ?><br>
        About <?php echo ($data_for_view['user']['Username']) ?>: <?php echo ' '.($data_for_view['user']['About_me']) ?><br>
        </h3>
        <h4><a  href = "/settings"> Edit </a> </h4>

    </form>
    </body>
</html>