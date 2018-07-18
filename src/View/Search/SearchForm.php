<li class="nav-item search">
    <form method="GET" action="/search">

        <input class="form-control mr-sm-2" type="text" name="query"
               value= <?php echo $data_for_view['query'] ?>
        >
        <button class="btn btn-outline-success my-50 my-sm-1 btn-block" type="submit"> Search</button>

</li>
<li class="nav-item ">
    Posts:
    <input title="status" type="checkbox" name="posts"
        <?php echo $data_for_view['is_posts_check'] ?>
    >
    <br>
    Users:
    <input title="status" type="checkbox" name="users"
        <?php if ($data_for_view['is_users_check']) { ?>
            checked
        <?php } ?>
    >
</li>
</form>
