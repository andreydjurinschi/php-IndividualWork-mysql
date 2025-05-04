
<?php

    if(!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit();
    }

    $user_role = $_SESSION['role_id'];
    if($user_role === 1) {
        echo "<h1>Welcome to the <strong>STUDNET</strong>, {$_SESSION['username']} !</h1>";
    }
?>
<h1>ALL POSTS PAGE</h1>