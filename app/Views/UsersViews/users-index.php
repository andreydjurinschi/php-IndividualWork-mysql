<table class="table">
    <thead class="thead-dark">
    <tr>
        <th scope="col">#</th>
        <th scope="col">Username</th>
        <th scope="col">Email</th>
        <th scope="col">Role</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <?php if (isset($users)) {
        foreach ($users as $user): ?>
            <tr>
                <th scope="row"><?= htmlspecialchars($user['id']) ?></th>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= $user['role_id'] == 1 ? 'Admin' : 'User' ?></td>
                <td>
                    <a href="/user/view?user_id=<?= htmlspecialchars($user['id']) ?>" class="btn btn-primary">Edit</a>
                </td>
            </tr>
        <?php endforeach;
    } ?>
    </tbody>
</table>