
<form method="post">
    <input type="hidden" name="action" value="login">
    <label>
        <input type="text" name="username" placeholder="Username" required>
    </label>
    <label>
        <input type="password" name="password" placeholder="Password" required>
    </label>
    <button type="submit">Login</button>
</form>
<?php
session_start();
if (isset($_SESSION['error'])) {
    echo $_SESSION['error'];
    unset($_SESSION['error']);
}?>
