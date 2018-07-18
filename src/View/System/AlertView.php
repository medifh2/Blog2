<?php if (isset($data_for_view['error_message'])) : ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $data_for_view['error_message'];
        unset($data_for_view['error_message']); ?>
    </div>

<?php endif; ?>

<?php if (isset($data_for_view['message'])) : ?>
    <div class="alert alert-success" role="alert">
        <?php echo $data_for_view['message'] . "<br>";
        unset($data_for_view['message']); ?>
    </div>
<?php endif; ?>