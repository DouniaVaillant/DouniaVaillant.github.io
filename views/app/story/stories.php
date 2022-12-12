<?php include(VIEWS . '_partials/header.php'); ?>

<h1>Histoires numériques</h1>

<div class="pageStory">

    <?php foreach ($stories as $story) : ?>
        <div class="stories">

            <a href="<?= BASE_PATH . 'library?id=' . $story['id']; ?>"><i class="fa-solid fa-bookmark <?php if (isset($inLibrary['id_story']) == $story['id']) : ?> bookmarkStoryInLibrary <?php else : ?> bookmarkStory <?php endif; ?>"></i></a>

            <h3 class="titleStories"><?= $story['title']; ?></h3>

            <a href="<?= BASE_PATH . 'story/show?id=' . $story['id']; ?>">
                <div class="cardStory">
                    <img class="coverStory" src="<?= BASE . 'upload/story/' . $story['photo']; ?>" alt="Image de couverture">
                </div>
            </a>

        </div>


        <div class="clickevent">

            <button id="btn" class="btn-deco-none" onclick="document.getElementById('stories-moreOptions-<?= $story['id']; ?>').classList.toggle('hide');">
                <i class="fa-solid fa-ellipsis-vertical stories-report"></i>
            </button>

            <div id="stories-moreOptions-<?= $story['id']; ?>" class="stories-moreOptions hide">
                <ul>
                    <li><a href="#">Lire</a></li>
                    <li><a href="<?= BASE_PATH . 'user/profile?id=' . $story['id_user']; ?>">Voir l'auteur</a></li>
                    <li><a href="<?= BASE_PATH . 'report?s=' . $story['id']; ?>">Signaler</a></li>
                </ul>
            </div>
    
        </div>
    <?php endforeach; ?>

</div>





<?php include(VIEWS . '_partials/footer.php'); ?>