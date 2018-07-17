<!DOCTYPE html>

<html>
<body> 
<form class = "content">
    <h6 class = "success">
        <?php if (isset($data_for_view['message']))
        {
            echo $data_for_view['message']."<br>";
            unset ($data_for_view['message']);
        }
        ?>
    </h6>
    <h1><?php echo ($data_for_view['other_user_data']['Username']) ?></h1>

    <?php  if (isset($_SESSION['user_id'])) if ($data_for_view['user']['Accesslvl'] == 'admin') { ?>
        <a   href = "/otheruseredit/<?php echo $data_for_view['other_user_data']['ID'] ?>" > [edit] </a>
    <?php } ?>

    <h3>
        <?php if ($data_for_view['other_user_data']['Status'])  echo ($data_for_view['other_user_data']['Status']).'<br>' ?>
        <?php echo ($data_for_view['other_user_data']['Accesslvl']) ?>
        <br>
        About <?php echo ($data_for_view['other_user_data']['Username']) ?>: <?php echo ' '.($data_for_view['other_user_data']['About_me']) ?><br>
    </h3>
</form>
</body>
</html>