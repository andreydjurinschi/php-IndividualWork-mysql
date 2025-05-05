<h1>ALL POSTS PAGE</h1>
<form method="GET" action="/search">
    <input type="text" name="title" placeholder="Search by title" />
    <button type="submit">Search</button>
</form>
<br>
<br>
<form method="GET" action="/allPosts" class="mb-4">
    <label for="sort">Sort by date</label>
    <select name="sort" id="sort" class="form-select w-auto d-inline-block mx-2">
        <option value="desc" <?= ($_GET['sort'] ?? '') === 'desc' ? 'selected' : '' ?>>Recent</option>
        <option value="asc" <?= ($_GET['sort'] ?? '') === 'asc' ? 'selected' : '' ?>>Latest</option>
    </select>
    <button type="submit" class="btn btn-primary">Применить</button>
</form>




<div class="container mt-4">
    <div class="row">
        <?php if (!empty($posts)) {
            foreach ($posts as $post): ?>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <img src="<?= htmlspecialchars(!empty($post['photo_path']) ? $post['photo_path'] : 'https://thumb.ac-illust.com/b1/b170870007dfa419295d949814474ab2_t.jpeg') ?>" class="card-img-top img-fixed" alt="Post image">
                        <div class="card-body badge-bg-light">
                            <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
                            <p class="card-text"><?= nl2br(htmlspecialchars(mb_strimwidth($post['content'], 0, 150, '...'))) ?></p>
                            <p class="text-muted small mb-1">Created at: <?= htmlspecialchars($post['created_at']) ?></p>

                            <?php if (!empty($post['tags'])): ?>
                                <div class="mb-2">
                                    <?php foreach ($post['tags'] as $tag): ?>
                                        <span class="badge text-primary">#<?= htmlspecialchars($tag) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($post['file_path'])): ?>
                                <a href="<?= htmlspecialchars($post['file_path']) ?>" class="btn btn-outline-secondary btn-sm" target="_blank">Download file</a>
                            <?php endif; ?>
                            <br>
                            <a href="/user/info?user_id=<?= htmlspecialchars($post['user_id']) ?>" class="text-muted medium mb-1">Author: <?= htmlspecialchars($post['username']) ?></a>

                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <a href="/post/view?id=<?= $post['id'] ?>" class="btn btn-primary btn-sm">Read more</a>

                                <?php if (
                                    isset($_SESSION['user_id']) &&
                                    ($_SESSION['user_id'] == $post['user_id'] || ($_SESSION['role_id'] ?? null) == 1)
                                ): ?>
                                    <a href="/post/update?id=<?= $post['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;
        } ?>
    </div>
</div>
