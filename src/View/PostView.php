<h2> <?php echo $post['Title'] ?> </h2>
<h5>
    <?php echo $post['Status'] ?>
    <br>
    <?php echo $post['Author'] . ",  " . $post['DatePub'] ?>
</h5>
<h4> <?php echo $post['Text'] ?> </h4>
<?php
if ($post['Image'] !== 'images/') { echo "<img src = '/{$post['Image']}'>"; }
?>
<br>
<a class="link" href="post/<?php echo $post['ID'] ?>"> Full </a>

    <a class="edit" href="/postedit/<?php echo $post['ID'] ?>"> [edit] </a>
