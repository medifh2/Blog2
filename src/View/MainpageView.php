<!DOCTYPE html>

<html>

<body>
<div class = "content">
    <h6 class = 'success'>
        <?php if (isset($data_for_view['message']))
        {
            echo $data_for_view['message'] . "<br>";
            unset($data_for_view['message']);
        }
        ?>
    </h6>
    <h1>Main page</h1>

    <?php
    foreach ($data_for_view['all_posts'] as $post)
    {
        if ($post['Status'] === 'published')
        {
        ?>
</div>
<div class = "put">
    <h2> <?php echo $post['Title'] ?> </h2>
    <h5> <?php echo $post['Author'].",  ".$post['DatePub'] ?> </h5>
    <h4> <?php echo $post['Text'] ?> </h4>
    <?php
    if ($post['Image'] !== 'images/') echo "<img src = '/{$post['Image']}'>"
    ?>
    <br>
    <a  class = "link" href = "post/<?php echo $post['ID'] ?>" > Full </a>
    <?php if (isset($_SESSION['user_id'])) if (($post ['Author'] == $data_for_view['user']['Login']) || ($data_for_view['user']['Accesslvl'] == 'admin')) {?>
        <a  class = "edit" href = "/postedit/<?php echo $post['ID'] ?>" > [edit] </a>
    <?php } ?>
</div>
<?php
}
}
?>
<div>
    <?php if ($data_for_view ['current_page'] > 0) {?>
        <a  href = "/page/<?php echo $data_for_view ['current_page']; ?>" > <-previous </a>
    <?php } ?>
    <?php
    for ($i = 1; $i <= $data_for_view['amount_pages']; $i++)
    {?>
        <a  href = "/page/<?php echo $i; ?>" > <?php echo $i; ?> </a>
    <?php
    }
    ?>
    <?php if ($data_for_view ['current_page'] < $data_for_view['amount_pages'] -1)
    {?>
    <a  href = "/page/<?php echo $data_for_view ['current_page'] + 2; ?>" > next-> </a>
    <?php } ?>
</div>
</body>
</html>