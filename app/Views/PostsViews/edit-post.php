<div class="container mt-4">
    <?php if (isset($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    <?php if (isset($post)): ?>
            <h1>Edit Post</h1>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($post['id']) ?>">
        <input type="hidden" name="action" value="update_post">

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="5" required><?= htmlspecialchars($post['content']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="photo_path" class="form-label">Photo Path (optional)</label>
            <input type="text" class="form-control" id="photo_path" name="photo_path" value="<?= htmlspecialchars($post['photo_path']) ?>">
            <?php if (!empty($post['photo_path'])): ?>
                <div class="mt-2">
                    <strong>Current Photo:</strong>
                    <a href="<?= htmlspecialchars($post['photo_path']) ?>" target="_blank">View Photo</a>
                </div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="file_path" class="form-label">File Path (optional)</label>
            <input type="text" class="form-control" id="file_path" name="file_path" value="<?= htmlspecialchars($post['file_path']) ?>">
            <?php if (!empty($post['file_path'])): ?>
                <div class="mt-2">
                    <strong>Current File:</strong>
                    <a href="<?= htmlspecialchars($post['file_path']) ?>" target="_blank">Download File</a>
                </div>
            <?php endif; ?>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <button type="submit" class="btn btn-primary">Update Post</button>
            <a href="/post/view?id=<?= htmlspecialchars($post['id']) ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
