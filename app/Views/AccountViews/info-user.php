<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
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
                    <label>Role</label>
                    <p class="form-control-plaintext">
                        <?= (isset($user) && $user['role_id'] == 1) ? 'Admin' : 'User' ?>
                    </p>
                    <input type="hidden" name="role_id" value="<?= isset($user) ? $user['role_id'] : 2 ?>">
                </div>

                <button type="submit" class="btn btn-primary btn-block">Submit</button>
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
