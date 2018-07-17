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
            <?php include $files["nav_content"] . ".php"; ?>
            <?php include "SearchForm.php"; ?>
        </ul>
    </div>
</nav>