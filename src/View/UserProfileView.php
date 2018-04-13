<!DOCTYPE html>

<html>
    <body>
    <form class = "content">

        <h1><?php echo ($_SESSION['Userdata']['Username']) ?></h1>
        <h3><?php echo ($_SESSION['Userdata']['Lvl']) ?><br>
        About <?php echo ($_SESSION['Userdata']['Username']) ?>: <?php echo ' '.($_SESSION['Userdata']['About_me']) ?><br>
        </h3>
        <h4><a  href = "/settings"> Edit </a> </h4>

    </form>
    </body>
</html>