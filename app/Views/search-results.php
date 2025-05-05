<!-- search-results.php -->
<h1>Search Results</h1>
<div class="container mt-4">
    <div class="row">
        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <img src="<?= htmlspecialchars($post['photo_path'] ?? 'default.jpg') ?>" class="card-img-top" alt="Post image">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
                            <p class="card-text"><?= nl2br(htmlspecialchars(mb_strimwidth($post['content'], 0, 150, '...'))) ?></p>
                            <a href="/post/view?id=<?= htmlspecialchars($post['id']) ?>" class="btn btn-primary">Read more</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No results found.</p>
        <?php endif; ?>
    </div>
</div>
