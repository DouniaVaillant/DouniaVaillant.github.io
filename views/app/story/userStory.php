<?php include(VIEWS . '_partials/header.php'); ?>

<h1>Mes livres</h1>

<a href="<?= BASE_PATH . 'story/add'; ?>" class="btn btn-warning">Créer une histoire</a>

<?php foreach ($stories as $story) : ?>

    <div class=" border-primary mb-3" style="max-width: 20rem;">
        <img src="<?= BASE . 'upload/story/' . $story['photo']; ?>" alt="<?= 'Couverture de ' . $story['title']; ?>" height="300">
        <div class="">
            <h4 class=""><?= $story['title']; ?></h4>
            <p class=""><?= $story['synopsis']; ?></p>
        </div>
        <a href="<?= BASE_PATH . 'user/stories/edit?id=' . $story['id']; ?>" class="btn bg-soil text-light"><i class="fas fa-edit"></i></a>
        <a onclick="return confirm('Etes-vous sûr de vouloir supprimer cette histoire ?')" href="<?= BASE_PATH . 'story/delete?id=' . $story['id']; ?>" class="btn bg-soil text-light"><i class="fas fa-trash"></i></a>
        <a href="<?= BASE_PATH . 'story/chapter/add?story=' . $story['id']; ?>" class="btn bg-soil text-light"><i class="fas fa-plus"></i></a>
    </div>





<?php endforeach; ?>













<?php include(VIEWS . '_partials/footer.php'); ?>