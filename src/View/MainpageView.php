<!DOCTYPE html>

<html>

<body>
<div class = "content">
    <h6 class = 'success'>
        <?php if ($_SESSION['message']) 
            echo $_SESSION['message']."<br>";
        $_SESSION['message'] = 0; 
        ?>
    </h6>
    <h1>Main page</h1>
    <form method = "post" action = "searching">
        <button class = "submit" type="submit">Search</button>
    </form>
    <?php 
    foreach ($_SESSION['Allposts'] as $post) 
    { if ($post['Status'] === 'published') { ?>
        <form class="put" method = "post" action = "fullpost">
            <h2> <?php echo $post['Title'] ?> </h2>
            
            <h5> <?php echo $post['Author'].",  ".$post['DatePub'] ?> </h5>
            <h4> <?php echo $post['Text'] ?> </h4>
            <?php 
            if ($post['Image'] !== 'images/') echo "<img src = '{$post['Image']}'>" 
            ?>
            <br>
            <input type = "hidden" name = "PostID" value = <?php echo $post['ID'] ?> >
            <button class = "link" type = "submit">Full post</button>
        </form>
    <?php } } ?>
    <?php if ($_SESSION['Islast']) echo "<a  href = 'more'> More </a>" ?>
</div>
</body>

</html>