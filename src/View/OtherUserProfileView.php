<!DOCTYPE html>

<html>
<body> 
<form class = "content">
    <h6 class = "success">
        <?php if ($_SESSION['message']) 
            echo $_SESSION['message']."<br>";
        $_SESSION['message'] = 0; 
        ?>
    </h6>
    <h1><?php echo ($_SESSION['OtherUserdata']['Username']) ?></h1>
    <h3><?php echo ($_SESSION['OtherUserdata']['Accesslvl']) ?><br>
        About <?php echo ($_SESSION['OtherUserdata']['Username']) ?>: <?php echo ' '.($_SESSION['OtherUserdata']['About_me']) ?><br>
    </h3>
</form>
</body>
</html>