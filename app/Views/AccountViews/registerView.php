<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h4 class="mb-4 text-center">Hello new USER!</h4>
            <h2 class="mb-4 text-center">Register</h2>
            <form method="post">
                <input type="hidden" name="action" value="register">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                </div>
                <div class="form-group">
                    <label for="email">Password</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>
            <div class="text-center mt-3">
                <a href="/login">Have an account?</a>
            </div>
            <?php
            if (!empty($error)) { ?>
                <div class="alert alert-danger mt-3" role="alert"><?= $error?></div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
