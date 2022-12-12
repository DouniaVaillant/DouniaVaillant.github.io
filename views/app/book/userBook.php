<?php include(VIEWS . '_partials/header.php'); ?>

<h1>Mes livres</h1>

<a href="<?= BASE_PATH . 'book/add'; ?>" class="btn btn-warning">Ajouter un livre</a>

<?php foreach ($books as $book) : ?>

    <div class=" border-primary mb-3" style="max-width: 20rem;">
        <img src="<?= BASE . 'upload/book/' . $book['photo']; ?>" alt="<?= 'Couverture de ' . $book['title']; ?>" height="300">
        <div class="">
            <h4 class=""><?= $book['title']; ?></h4>
            <p class=""><?= $book['synopsis']; ?></p>
        </div>
        <a href="<?= BASE_PATH . 'user/books/edit?id=' . $book['id']; ?>" class="btn bg-soil text-light"><i class="fas fa-edit"></i></a>
        <a href="<?= BASE_PATH . 'user/books/delete?id=' . $book['id']; ?>" class="btn bg-soil text-light"><i class="fas fa-trash"></i></a>
    </div>





<?php endforeach; ?>













<?php include(VIEWS . '_partials/footer.php'); ?>