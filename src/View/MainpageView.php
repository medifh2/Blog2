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
    <form method = "post" action = "searching">
        <button class = "submit" type="submit">Search</button>
    </form>
    <?php 
    foreach ($data_for_view['all_posts'] as $post)
    { if ($post['Status'] === 'published') { ?>
        <form class="put" >
            <h2> <?php echo $post['Title'] ?> </h2>
            
            <h5> <?php echo $post['Author'].",  ".$post['DatePub'] ?> </h5>
            <h4> <?php echo $post['Text'] ?> </h4>
            <?php 
            if ($post['Image'] !== 'images/') echo "<img src = '{$post['Image']}'>" 
            ?>
            <br>
            <input type = "hidden" name = "PostID" value = <?php echo $post['ID'] ?> >
            <a  class = "link" href = "fullpost-<?php echo $post['ID'] ?>" type = "submit"> Full </a>
        </form>
    <?php } } ?>
    <?php if ($data_for_view['is_last']) echo "<a  href = 'more'> More </a>" ?>
</div>
</body>

</html>