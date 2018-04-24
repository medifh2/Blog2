<!DOCTYPE html>

<html>

<body>
<div class = "content">
    <h6 class = 'success'>
        <?php if (isset($data_for_view['message']))
            echo $data_for_view['message']."<br>";
        $data_for_view['message'] = 0;
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
    if ($post['Image'] !== 'images/') echo "<img src = '{$post['Image']}'>"
    ?>
    <br>
    <a  class = "link" href = "post/<?php echo $post['ID'] ?>" > Full </a>
</div>
<?php
}
}
?>

</body>

</html>