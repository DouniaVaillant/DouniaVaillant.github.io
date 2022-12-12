<?php include(VIEWS . '_partials/header.php'); ?>



<form action="<?php if (isset($_GET['id'])) {
                    echo BASE_PATH . 'admin/target-reader/edit';
                } else {
                    echo BASE_PATH . 'admin/target-reader/add';
                } ?>" method="POST">
    <div class="mb-3">
        <?php if (isset($targetReader)) : ?>
            <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
        <?php endif; ?>
        <label for="title" class="form-label">Lectorat ciblé</label>
        <input name="title" type="text" value="<?= $targetReader['title'] ?? ''; ?>" class="form-control" id="">
        <small class="text-danger"><?= $error['title'] ?? ""; ?></small>
    </div>
    <button type="submit" class="btn btn-success">Enregistrer</button>
</form>

















<?php include(VIEWS . '_partials/footer.php'); ?>