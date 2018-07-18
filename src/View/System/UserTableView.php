<table class="table table-striped table-dark">
    <thead>
    <tr>
        <th scope="col"> ID </th>
        <th scope="col"> Login </th>
        <th scope="col"> Username </th>
        <th scope="col"> About me </th>
        <th scope="col"> Access </th>
        <th scope="col"> Date of registration </th>
        <th scope="col"> Status </th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data_for_view['all_users'] as $user) { ?>
        <tr>
            <th scope="row">
                <?php echo $user['ID'] ?>
            </th>
            <td>
                <?php echo $user['Login'] ?>
            </td>
            <td>
                <?php echo $user['Username'] ?>
            </td>
            <td>
                <?php echo $user['About_me'] ?>
            </td>
            <td>
                <?php echo $user['Accesslvl'] ?>
            </td>
            <td>
                <?php echo $user['RegDate'] ?>
            </td>
            <td>
                <?php echo $user['Status'] ?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
