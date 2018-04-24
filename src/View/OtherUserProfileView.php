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
    <h1><?php echo ($data_for_view['other_user_data']['Username']) ?></h1>
    <h3>
        <?php echo ($data_for_view['other_user_data']['Accesslvl']) ?>
        <br>
        About <?php echo ($data_for_view['other_user_data']['Username']) ?>: <?php echo ' '.($data_for_view['other_user_data']['About_me']) ?><br>
    </h3>
</form>
</body>
</html>