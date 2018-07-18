<?php
foreach ($data_for_view["posts"] as $data_for_view['post']):?>
    <div class="put">
        <a class="link" href="post/<?php echo $data_for_view['post']['ID'] ?>"> Full </a>
        <?php View\View::attachUnit("PostView", $data_for_view); ?>
        <a class="link" href="post/<?php echo $data_for_view['post']['ID'] ?>"> Full </a>
    </div>
<?php endforeach; ?>

<?php if ($data_for_view ['current_page'] > 0): ?>
    <a href="/page/<?php echo $data_for_view ['current_page']; ?>"> <-previous </a>
<?php endif; ?>
<?php if (!($data_for_view['amount_pages'] <= 1)) : ?>
    <?php for ($i = 1; $i <= $data_for_view['amount_pages']; $i++) : ?>
        <a href="/page/<?php echo $i; ?>"> <?php echo $i; ?> </a>
    <?php endfor; ?>
    <?php if ($data_for_view ['current_page'] < $data_for_view['amount_pages'] - 1) : ?>
        <a href="/page/<?php echo $data_for_view ['current_page'] + 2; ?>"> next-> </a>
    <?php endif; ?>
<?php endif; ?>
    