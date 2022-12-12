<?php include(VIEWS . '_partials/header.php'); ?>

<form action="<?php if (isset($_GET['id'])): echo BASE_PATH . 'user/stories/edit'; else : echo BASE_PATH . 'story/add'; endif; ?>" method="POST" enctype="multipart/form-data">


    <?php if (isset($story)) : ?>
        <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
        <input type="hidden" name="photo" value="<?= $story['photo']; ?>">
        <div class="form-group">
            <label for="coverFile" class="form-label mt-4">Photo de couverture</label>
            <input name="photoCoverUpdate" onchange="loadFileCover(event)" class="form-control" type="file" id="coverFile">
            <small class="text-danger"><?= $error['photo'] ?? ""; ?></small>
            <img src="<?= BASE . 'upload/story/' . $story['photo']; ?>" height="300" alt="Couverture">
            <img id="cover" height="300" alt="Couverture">
        </div>
    <?php else : ?>
        <div class="form-group">
            <label for="oldCoverFile" class="form-label mt-4">Photo de couverture</label>
            <input name="photo" onchange="loadFileCover(event)" class="form-control" type="file" id="oldCoverFile">
            <img id="cover" height="300" alt="Couverture">
        </div>
    <?php endif; ?>

    <label for="category" class="form-label mb-3">Genre littéraire</label>
    <select name="category" class="form-select" aria-label="Default select example">
        <option selected>Selectionner</option>
        <?php foreach ($categories as $category) : ?>
            <option <?php if (isset($story) && $story['category'] == $category['title']) : echo 'selected';
                    endif; ?> value="<?= $category['title']; ?>"><?= $category['title']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <small class="text-danger"><?= $error['category'] ?? ""; ?></small>
    <div class="mb-3">
        <label for="target_reader" class="form-label">Lectorat cible</label>
        <select name="target_reader" value="<?= $_POST['target_reader'] ?? $story['target_reader']; ?>" class="form-select" aria-label="Default select example">
            <option selected>Selectionner</option>
            <?php foreach ($targetReader as $target) : ?>
                <option <?php if (isset($story) && $story['target_reader'] == $target['title']) : echo 'selected';
                        endif; ?> value="<?= $target['title']; ?>"><?= $target['title']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <small class="text-danger"><?= $error['target_reader'] ?? ""; ?></small>
    </div>

    <div class="mb-3">
        <label for="title" class="form-label">Titre</label>
        <input name="title" value="<?= $story['title'] ?? ''; ?>" type="text" class="form-control" id="title">
        <small class="text-danger"><?= $error['title'] ?? ""; ?></small>
    </div>

    <div class="mb-3">
        <label for="synopsis" class="form-label">Synopsis</label>
        <textarea name="synopsis" class="form-control" id=""><?= $story['synopsis'] ?? ''; ?></textarea>
        <small class="text-danger"><?= $error['synopsis'] ?? ""; ?></small>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">statut</label>
        <select name="status" value="<?= $_POST['status'] ?? $story['status']; ?>" class="form-select" aria-label="Default select example">
            <option value="Brouillon" selected>Brouillon</option>
                <option value="En réecriture">En réecriture</option>
                <option value="Terminé">Terminé</option>
        </select>
        <small class="text-danger"><?= $error['status'] ?? ""; ?></small>
    </div>

    <div class="mb-3 form-check">
        <label for="language" class="form-label">Langue</label>
        <select name="language" value="<?= $_POST['status'] ?? $story['status']; ?>" class="form-select">
            <option value="<?= $_POST['language'] ?? 'Français'; ?>" >Français</option>
            <option value="<?= $_POST['language'] ?? 'Anglais'; ?>" >Anglais</option>
            <option value="<?= $_POST['language'] ?? 'Italien'; ?>" >Italien</option>
            <option value="<?= $_POST['language'] ?? 'Espagnol'; ?>" >Espagnol</option>
            <option value="<?= $_POST['language'] ?? 'Allemand'; ?>" >Allemand</option>
            <option value="<?= $_POST['language'] ?? 'Portugais'; ?>" >Portugais</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Enregistrer</button>
    <!-- <a href="<?= BASE_PATH . 'story/chapter/add?story=' . $story['id']; ?>" class="btn bg-lightBrown">Ajouter un chapitre</a> -->

</form>








<script>
    let loadFileCover = function(event) {
        let cover = document.getElementById('cover');
        cover.src = URL.createObjectURL(event.target.files[0]);
    }
</script>



<?php include(VIEWS . '_partials/footer.php'); ?>