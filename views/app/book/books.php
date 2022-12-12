<?php include(VIEWS . '_partials/header.php'); ?>

<h1>Livres papiers</h1>
<div class="cards">
    <?php foreach ($books as $book) : ?>
        <?php $user = User::findById(['id' => $book['id_user']]); ?>
        <a href="<?= BASE_PATH . 'book/show?id=' . $book['id']; ?>">
            <div class="cardBook">
                <div class="right">
                    <img src="<?= BASE . 'upload/book/' . $book['photo']; ?>" alt="Image de couverture" class="coverBook">
                    <h3 class="title"><?= $book['title']; ?></h3>
                </div>
                <div class="left">
                    <div class="tags">
                        <p class="status"><?= $book['status']; ?></p>
                        <p class="separator">∣</p>
                    </div>
                    <div class="bgSynopsis">
                        <p class="synopsis"><?= $book['synopsis']; ?></p>
                    </div>
                    <div class="comment">
                        <?php if (isset($user['id'])) : ?>
                        <div class="user">
                            <img class="photoProfile" src="<?= BASE . 'upload/photos/profile/' . $user['photo_profile']; ?>" alt="Photo de profil">
                            <?= $user['pseudo']; ?>
                        </div>
                        <div class="bgCommentUser">
                            <p class="commentUser">Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim saepe id sint praesentium dolor tenetur officia voluptates, dolores accusamus ad earum non, in nostrum porro excepturi, maxime sit iusto molestias.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            </a>
    <?php endforeach; ?>
</div>



<?php include(VIEWS . '_partials/footer.php'); ?>