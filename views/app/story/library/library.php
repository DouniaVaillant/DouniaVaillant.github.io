<?php include(VIEWS . '_partials/header.php'); ?>

<div class="pageLibrary">

    <h1>Bibliothèque</h1>

    <div class="library-1">

        <?php foreach ($library as $data) : ?>
            <div class="cardLibrary">

                <a href="<?= BASE_PATH . 'story/show?id=' . $data['id_story']; ?>">
                    <img class="coverLibrary" src="<?= BASE . 'upload/story/' . $data['photo']; ?>" alt="Couverture - <?= $data['title']; ?>">
                </a>
                <h3 class="titleStory"><?= $data['title']; ?></h3>

            </div>
            <?php endforeach; ?>

    </div>

</div>













<?php include(VIEWS . '_partials/footer.php'); ?>