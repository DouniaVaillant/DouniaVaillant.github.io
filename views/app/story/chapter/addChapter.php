<?php include(VIEWS . '_partials/header.php'); ?>

<form action="<?= BASE_PATH . 'story/chapter/add'; ?>" method="post">

    <input type="hidden" name="id_story" value="<?= $_GET['story']; ?>">


    <div class="mb-3 text-end">
        <button class="btn bg-lightBrown" type="submit">Publier</button>
    </div>

    <div class="mb-3 row justify-content-center">
        <div class="col-8">
            <label for="title" class="form-label"></label>
            <input name="title" value="<?= $chapter['title'] ?? ''; ?>" type="text" class="form-control" id="title" placeholder="Nom du chapitre">
            <small class="text-danger"><?= $error['title'] ?? ""; ?></small>
        </div>

        <div class="col-3">
            <label for="chapter_number" class="form-label"></label>
            <input type="number" class="form-control" name="chapter_number" min="1" id="chapter_number" placeholder="Numéro du chapitre">
            <small class="text-danger"><?= $error['title'] ?? ""; ?></small>
        </div>

    </div>

    <div class="mb-3">
        <label for="content" class="form-label"></label>
        <textarea name="content" class="form-control" rows="30"><?= $chapter['content'] ?? ''; ?></textarea>
        <small class="text-danger"><?= $error['content'] ?? ""; ?></small>
    </div>







</form>


<?php include(VIEWS . '_partials/footer.php'); ?>