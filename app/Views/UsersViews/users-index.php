<table class="table">
    <thead class="thead-dark">
    <tr>
        <th scope="col">#</th>
        <th scope="col">Username</th>
        <th scope="col">Email</th>
        <th scope="col">Role</th>
        <th scope="col"></th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <?php if (isset($users)) : ?>
        <?php foreach ($users as $user) : ?>
            <tr class="<?= $user['id'] == $_SESSION['user_id'] ? 'table-primary' : '' ?>">
                <th scope="row"><?= htmlspecialchars($user['id']) ?></th>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= $user['role_id'] == 1 ? 'Admin' : 'User' ?></td>
                <td>
                    <?php if ($user['id'] != $_SESSION['user_id']) : ?>
                        <a href="/user/view?user_id=<?= htmlspecialchars($user['id']) ?>" class="btn btn-primary">Edit</a>
                        <a href="/user/info?user_id=<?= htmlspecialchars($user['id']) ?>" class="btn btn-primary">Info</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>

    </tbody>
</table>