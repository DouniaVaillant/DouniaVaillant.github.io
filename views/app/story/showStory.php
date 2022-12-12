<?php include(VIEWS . '_partials/header.php'); ?>
<?php $user = User::findById(['id' => $story['id_user']]); ?>



<div class="pageShowStory showStory-1">



    <div class="showStory-2-1">
        <?php if ($user) : ?>
            <!-- <img src="<?= BASE . 'upload/photos/profile/' . $user['photo_profile']; ?>" class="roundProfile" alt="Photo de profil"> -->
            <h1><?= $user['pseudo']; ?> vous propose:</h1>
        <?php else : ?>
            <h1>Un membre vous propose:</h1>
        <?php endif; ?>
    </div>




    <div class="showStory-2-2">

        <div class="showStory-3-1">
            <h2><?= $story['title']; ?></h2>
            <img src="<?= BASE . 'upload/story/' . $story['photo']; ?>" alt="Couverture de <?= $story['title']; ?>">
        </div>


        <div class="showStory-3-2">
            <p><strong>Synopsis: <br></strong><?= $story['synopsis']; ?></p>
        </div>

        
        <div class="showStory-clickevent">
            <button id="btn" class="btn-deco-none" onclick="document.getElementById('story-moreOptions-<?= $story['id']; ?>').classList.toggle('hide');">
                <i class="fa-solid fa-ellipsis-vertical showStory-report"></i>
            </button>

            <div id="story-moreOptions-<?= $story['id']; ?>" class="story-moreOptions hide">
                <ul>
                    <li><a href="#">Lire</a></li>
                    <li><a href="<?= BASE_PATH . 'user/profile?id=' . $story['id_user']; ?>">Voir l'auteur</a></li>
                    <li><a href="<?= BASE_PATH . 'report?s='. $story['id']; ?>">Signaler</a></li>
                </ul>
            </div>
        </div>


        <div class="showStory-3-3">
            <?php if (!empty($story['status'])) : ?>
                <span class="showStory-status"><?= $story['status']; ?></span>
            <?php else : ?>
                <span class="showStory-status">En cours</span>

            <?php endif; ?>
            <p><strong>Publié le: </strong><?= $story['date_created']; ?></p>
            <p><strong>Dernière modification: </strong><?= $story['date_created']; ?></p>
        </div>


        <div class="showStory-3-4">

            <form action="<?= BASE_PATH . 'story/show?id=' . $story['id']; ?>" method="post">
                <button type="submit" class="btn-deco-none" name="likes">
                    <?php if (isset($_SESSION['user']) && ($likeFound && ($likeFound['likes'] == 1))) : ?>
                        <i class="fa-solid fa-heart text-danger"></i>
                    <?php else : ?>
                        <i class="fa-regular fa-heart text-danger"></i>
                    <?php endif; ?>
                </button>
                <?= $countLikes; ?>
            </form>

            <a href="#">Lire</a>

            <a href="#"><i class="fas fa-plus"></i></a>

        </div>


        <div class="showStory-3-5">
            <span class="showStory-target"><?= $story['target_reader']; ?></span>
        </div>

    </div>




    <div class="showStory-2-3">

        <div class="showStory-separator"></div>

        <h2>Découvrez</h2>

        <div class="showStory-3-1">

            <?php foreach ($discoverStories as $story) : ?>
                <div class="showStory-card">
                    <a href="<?= BASE_PATH . 'library?id=' . $story['id']; ?>"><i class="fa-solid fa-bookmark <?php if (isset($inLibrary['id_story']) == $story['id']) : ?> bookmarkStoryInLibrary <?php else : ?> bookmarkStory <?php endif; ?>"></i></a>
                    <h3><?= $story['title']; ?></h3>
                    <a href="<?= BASE_PATH . 'story/show?id=' . $story['id']; ?>">
                        <img class="showStory-discover" src="<?= BASE . 'upload/story/' . $story['photo']; ?>" alt="">
                    </a>
                </div>
            <?php endforeach; ?>

        </div>
    </div>


</div>




<?php include(VIEWS . '_partials/footer.php'); ?>