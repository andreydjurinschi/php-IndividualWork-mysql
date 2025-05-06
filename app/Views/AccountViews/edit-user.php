<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4 text-center">Edit <?= isset($user) ? htmlspecialchars($user['username']) : '' ?></h2>
            <form method="post" action="/user/update">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="<?= isset($user) ? $user['id'] : '' ?>">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?= isset($user) ? htmlspecialchars($user['username']) : '' ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" value="<?= isset($user) ? htmlspecialchars($user['email']) : '' ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="role_id">Role</label>
                    <select class="form-control" id="role_id" name="role_id">
                        <option value="1" <?= (isset($user) && $user['role_id'] == 1) ? 'selected' : '' ?>>Admin</option>
                        <option value="2" <?= (isset($user) && $user['role_id'] == 2) ? 'selected' : '' ?>>User</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </form>
        <form method="post" action="/user/delete" onsubmit="return confirm('Are you sure?');">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?= isset($user) ? $user['id'] : '' ?>">
            <button type="submit" class="btn btn-danger btn-block mt-2">Delete user</button>
        </form>
        </div>
        <?php
        if (!empty($error)) { ?>
            <div class="alert alert-danger mt-3" role="alert"><?= $error?></div>
            <?php
        }
        ?>
    </div>
</div>

<?php echo '<pre>';
print_r($_GET);
echo '</pre>';
?>