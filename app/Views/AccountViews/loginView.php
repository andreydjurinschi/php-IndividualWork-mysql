<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4 text-center">Login</h2>
            <form method="post">
                <input type="hidden" name="action" value="login">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
            <div class="text-center mt-3">
                <a href="/register">Don't have an account? Register</a>
            </div>
            <?php
            session_start();
            if (isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger mt-3" role="alert"><?= htmlspecialchars($_SESSION['error'])?></div>
            <?php    unset($_SESSION['error']);
            }
            ?>
        </div>
    </div>
</div>
