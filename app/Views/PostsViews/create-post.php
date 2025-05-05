<form method="post" class="container mt-4">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" class="form-control" >
    </div>
        <input type="hidden" name="action" value="create_post" class="form-control" >
    <div class="form-group">
        <label for="content">Content</label>
        <textarea name="content" id="content" rows="5" class="form-control" ></textarea>
    </div>

    <div class="form-group">
        <label for="photo_path">Photo URL (optional)</label>
        <input type="url" name="photo_path" id="photo_path" class="form-control" placeholder="https://example.com/photo.jpg">
    </div>

    <div class="form-group">
        <label for="file_path">File URL (optional)</label>
        <input type="url" name="file_path" id="file_path" class="form-control" placeholder="https://example.com/file.pdf">
    </div>

    <button type="submit" class="btn btn-primary">Create Post</button>
</form>
<?php
if (!empty($error)) { ?>
    <div class="alert alert-danger mt-3" role="alert"><?= $error?></div>
    <?php
}
?>

