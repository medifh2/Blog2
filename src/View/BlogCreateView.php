<body>
<form class="content" method="post" action="createpost">
    <input type="text" name="title" placeholder="Title" required/>
    <br>
    <input type="hidden" name="size" value="30000"/>
    <input type="file" name="image"/>
    <br>
    <textarea title='Your post' name='text' cols="60" rows="15"></textarea>
    <br>
    Publish: <input title="status" type="checkbox" name="status"> <br><br>
    <button class="btn btn-primary" type="submit">Create</button>
</form>
</body>
