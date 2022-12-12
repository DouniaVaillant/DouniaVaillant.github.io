<?php include(VIEWS . '_partials/header.php'); ?>


<form action="<?php if (isset($_GET['id'])) {
                    echo BASE_PATH . 'admin/category/edit';
                } else {
                    echo BASE_PATH . 'admin/category/add';
                } ?>" method="POST">
    <div class="mb-3">
        <?php if (isset($category)) : ?>
            <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
        <?php endif; ?>
        <label for="title" class="form-label">Titre</label>
        <input name="title" type="text" value="<?= $category['title'] ?? ''; ?>" class="form-control" id="title">
        <small class="text-danger"><?= $error['title'] ?? ""; ?></small>
    </div>
    <button type="submit" class="btn btn-success">Enregistrer</button>
</form>

















<?php include(VIEWS . '_partials/footer.php'); ?>