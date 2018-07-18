<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/">
        <img class="logo" alt="Brand" src='/images/logo/<?php echo $data_for_view['logo'] ?>'>
    </a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class=" navbar-collapse  collapse justify-content-end" id="navbarCollapse">
        <ul class="navbar-nav">
            <?php View\View::attachUnit($files["nav_content"], $data_for_view); ?>
            <?php View\View::attachUnit("SearchForm", $data_for_view); ?>
        </ul>
    </div>
</nav>