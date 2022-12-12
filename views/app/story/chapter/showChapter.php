<?php include(VIEWS . '_partials/header.php'); ?>


<h1 class="text-center"><?= $chapter['title']; ?></h1>
<div class="col-lg-6">
    <p class="px-5" style="text-align: justify;">
        <?= $chapter['content']; ?><br>
    </p>
</div>
<form action="<?= BASE_PATH . 'story/chapter/show?id=' . $chapter['id']; ?>" method="post">
    <div>
        <button type="submit" class="btn" name="likes">
            <?php if ($likeFound && ($likeFound['likes'] == 1)) : ?>
                <i class="fa-solid fa-heart"></i>
            <?php else : ?>
                <i class="fa-regular fa-heart"></i>
            <?php endif; ?>
        </button>
    </div>
</form>


<div class="showChapter-clickevent">
    <button id="btn" class="btn-deco-none" onclick="document.getElementById('chapter-moreOptions-<?= $chapter['id']; ?>').classList.toggle('hide');">
        <i class="fa-solid fa-ellipsis-vertical showChapter-report"></i>
    </button>

    <div id="chapter-moreOptions-<?= $chapter['id']; ?>" class="chapter-moreOptions hide">
        <ul>
            <li><a href="<?= BASE_PATH . 'user/profile?id=' . $story['id_user']; ?>">Voir l'auteur</a></li>
            <li><a href="<?= BASE_PATH . 'report?c=' . $chapter['id']; ?>">Signaler</a></li>
        </ul>
    </div>
</div>

<div class="">
    <form action="<?= BASE_PATH . 'story/chapter/show?id=' . $chapter['id']; ?>" method="POST">
        <div class="mb-3">
            <label for="comment" class="form-label">commentaire</label>
            <textarea name="comment" class="form-control" id="comment" rows="3" style="resize: none;"></textarea>
            <small><?= $error['comment'] ?? ""; ?></small>
            <button class="btn bg-lightGreen darkGreen" type="submit">Envoyer</button>
        </div>
    </form>
</div>
<?php foreach ($comments as $comment) : ?>
    <div class="otherComment">
        <?php $otherCommentUser = User::findById(['id' => $comment['id_commentator']]); ?>
        <img class="roundProfile" src="<?= BASE . 'upload/photos/profile/' . $otherCommentUser['photo_profile']; ?>" alt="Photo de profil">
        <?= $otherCommentUser['pseudo']; ?>
        <p><?= $comment['comment']; ?></p><br>
    </div>
<?php endforeach; ?>






















<?php include(VIEWS . '_partials/footer.php'); ?>