<?php include(VIEWS . '_partials/header.php');

if (!isset($_SESSION['user'])) {
  header('location:../');
  exit();
}

?>

<?php if (isset($_GET['id'])) : ?>
  <h1>Modifier <i class="text-muted"><?= $book['title']; ?></i></h1>
<?php endif; ?>

<form action="<?php if (isset($_GET['id'])) {
                echo BASE_PATH . 'user/books/edit?id=' . $book['id'];
              } else {
                echo BASE_PATH . 'book/add';
              } ?>" method="POST" enctype="multipart/form-data">

  <?php if (isset($book)) : ?>
    <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
    <input type="hidden" name="photo" value="<?= $book['photo']; ?>">
    <div class="form-group">
      <label for="coverFile" class="form-label mt-4">Photo de couverture</label>
      <input name="photoCoverUpdate" onchange="loadFileCover(event)" class="form-control" type="file" id="coverFile">
      <small class="text-danger"><?= $error['photo'] ?? ""; ?></small>
      <img src="<?= BASE . 'upload/book/' . $book['photo']; ?>" height="300" alt="Couverture">
      <img id="cover" height="300" alt="Image de couverture">
    </div>
  <?php else : ?>
    <div class="form-group">
      <label for="oldCoverFile" class="form-label mt-4">Photo de couverture</label>
      <input name="photo" onchange="loadFileCover(event)" class="form-control" type="file" id="oldCoverFile">
      <img id="cover" height="300" alt="Couverture">
    </div>
  <?php endif; ?>

  <div class="mb-3">
    <label for="title" class="form-label">Titre</label>
    <input name="title" value="<?= $book['title'] ?? ''; ?>" type="text" class="form-control" id="title">
    <small class="text-danger"><?= $error['title'] ?? ""; ?></small>
  </div>
  <div class="mb-3">
    <label for="synopsis" class="form-label">Synopsis</label>
    <textarea name="synopsis" class="form-control" id=""><?= $book['synopsis'] ?? ''; ?></textarea>
    <small class="text-danger"><?= $error['synopsis'] ?? ""; ?></small>
  </div>
  <div class="mb-3">
    <label for="author" class="form-label">Auteur.trice</label>
    <input name="author" value="<?= $book['author'] ?? ''; ?>" type="text" class="form-control" id="author">
    <small class="text-danger"><?= $error['author'] ?? ""; ?></small>
  </div>
  <div class="mb-3">
    <label for="editor" class="form-label">Editeur</label>
    <input name="editor" value="<?= $book['editor'] ?? ''; ?>" type="text" class="form-control" id="editor">
    <small class="text-danger"><?= $error['editor'] ?? ""; ?></small>
  </div>
  <div class="mb-3">
    <label for="date_publication" class="form-label">Date de publication</label>
    <input type="number" value="<?= $book['date_publication'] ?? ''; ?>" class="form-control" min="1000" max="<?= date('Y'); ?>" name="date_publication" step="1" value="AAAA" />
    <small class="text-danger"><?= $error['date_publication'] ?? ""; ?></small>
  </div>
  <div class="mb-3">
    <label for="category" class="form-label">Genre littéraire</label>
    <select name="category" class="form-select" aria-label="Default select example">
      <option selected>Selectionner</option>
      <?php foreach ($categories as $category) : ?>
        <option <?php if (isset($book) && $book['category'] == $category['title']) : echo 'selected';
                endif; ?> value="<?= $category['title']; ?>"><?= $category['title']; ?>
        </option>
      <?php endforeach; ?>
    </select>
    <small class="text-danger"><?= $error['category'] ?? ""; ?></small>
    <div class="mb-3">
      <label for="target_reader" class="form-label">Lectorat cible</label>
      <select name="target_reader" value="<?= $_POST['target_reader'] ?? $book['target_reader']; ?>" class="form-select" aria-label="Default select example">
        <option selected>Selectionner</option>
        <?php foreach ($targetReader as $target) : ?>
          <option <?php if (isset($book) && $book['target_reader'] == $target['title']) : echo 'selected';
                  endif; ?> value="<?= $target['title']; ?>"><?= $target['title']; ?>
          </option>
        <?php endforeach; ?>
      </select>
      <small class="text-danger"><?= $error['target_reader'] ?? ""; ?></small>
    </div>
    <legend>Statut du livre</legend>
    <small>Si vous proposez au don ou au partage vous acceptez d'être contacté.e par mail par des membres intéressés par le livre</small>
    <div class="mb-3 form-check">
      <input <?php if (isset($book) && $book['status'] == 'partage') : echo 'selected';
              endif; ?> class="form-check-input" type="radio" name="status" id="" value="partage">
      <label class="form-check-label" for="status">
        <span class="" data-toggle="tooltip" data-placement="top" title="Signifie que vous propsez aux autres membres d'emprunter ce livre. Vos coordonnées serons donc publiques.">
          <i class="fa-solid fa-circle-info"></i>
        </span>
        Disponible au partage
      </label>
    </div>
    <div class="mb-3 form-check">
      <input <?php if (isset($book) && $book['status'] == 'don') : echo 'selected';
              endif; ?> class="form-check-input" type="radio" name="status" id="" value="don">
      <label class="form-check-label" for="status">
        <span class="" data-toggle="tooltip" data-placement="top" title="Signifie que vous proposez au don ce livre.">
          <i class="fa-solid fa-circle-info"></i>
        </span>
        Disponible au don
      </label>
    </div>
    <div class="mb-3 form-check">
      <input <?php if (isset($book) && $book['status'] == 'documentation') : echo 'selected';
              endif; ?> class="form-check-input" type="radio" name="status" id="" value="documentation" checked>
      <label class="form-check-label" for="status">
        <span class="" data-toggle="tooltip" data-placement="top" title="Ni don, ni partage vous commentez juste un livre que vous venez de lire.">
          <i class="fa-solid fa-circle-info"></i>
        </span>
        Juste en documentation
      </label>
      <small class="text-danger"><?= $error['status'] ?? ""; ?></small>
    </div>

    <button type="submit" class="btn btn-primary">Publier</button>
</form>








<script>
  let loadFileCover = function(event) {
    let cover = document.getElementById('cover');
    cover.src = URL.createObjectURL(event.target.files[0]);
  }
</script>







<?php include(VIEWS . '_partials/footer.php'); ?>