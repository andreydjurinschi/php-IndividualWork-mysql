<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>STUDNET - <?= isset($title) ? htmlspecialchars($title) : '' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
</head>
<body>

<header class="bg-dark text-white py-3 mb-4">
    <div class="container d-flex justify-content-between align-items-center">
        <h1 class="h4 mb-0">STUDNET</h1>
        <nav>
            <ul class="nav">
                <li class="nav-item"><a class="nav-link text-white" href="/">Main Page</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/allPosts">All Posts</a></li>

                <?php if (isset($_SESSION['user_id'])){ ?>
                    <?php
                    // Проверяем роль пользователя, чтобы добавить пункт меню для админа
                    if ($_SESSION['role_id'] == 1) {
                        ?>
                        <li class="nav-item"><a class="nav-link text-white" href="/allUsers">All Users</a></li>
                    <?php } ?>
                    <li class="nav-item"><a class="nav-link text-white" href="/logout">Logout</a></li>
                <?php } ?>

                <?php if (!isset($_SESSION['user_id'])){ ?>
                    <li class="nav-item"><a class="nav-link text-white" href="/login">Login</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="/register">Register</a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</header>


<main class="container">
    <?= $content ?? '' ?>
</main>

<footer class="bg-light text-center py-3 mt-4">
    <p class="mb-0">STUDNET &copy; <?= date('Y') ?></p>
</footer>

</body>
</html>
