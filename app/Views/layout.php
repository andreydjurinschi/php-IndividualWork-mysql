<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>STUDNET <?= isset($title) ? htmlspecialchars($title) : '' ?></title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li>MAIN PAGE</li>
                <li>...</li>
                <li>...</li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="content">
            <?= isset($content) ? $content : '' ?>
        </div>
    </main>
    <footer>
        <p>STUDNET &copy; <?= date('Y') ?></p>
    </footer>
</body>
</html>