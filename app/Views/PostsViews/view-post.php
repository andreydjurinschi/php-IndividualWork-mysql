
<div class="container mt-4">
    <?php if (isset($post, $user)): ?>
        <h2>Post by <span class="text-primary"><?= $user['username'] ?></span></h2>
    <?php endif; ?>

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($post['title']) ?>" readonly>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="5" readonly><?= htmlspecialchars($post['content']) ?></textarea>
        </div>

        <div class="mb-3">
            <?php if (!empty($post['photo_path'])): ?>
                <div class="mt-2">
                    <strong>Current Photo:</strong>
                    <img src="<?= htmlspecialchars($post['photo_path']) ?>" alt="Post Image" class="img-thumbnail" style="max-width: 150px;">
                </div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <?php if (!empty($post['file_path'])): ?>
                <div class="mt-2">
                    <strong>Current File:</strong>
                    <a href="<?= htmlspecialchars($post['file_path']) ?>" target="_blank">Download</a>
                </div>
            <?php endif; ?>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <a href="/allPosts" class="btn btn-secondary">Back to Posts</a>
        </div>
</div>
