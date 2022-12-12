<?php include(VIEWS . '_partials/header.php'); ?>
<?php $user = User::findById(['id' => $book['id_user']]); ?>

<div class="showBook-1">
    <div class="showBook-2 showBook-2-1">
        <div class="showBook-moreOptions">
            <ul>
                <li><a href="<?= BASE_PATH . 'report?b=' . $book['id']; ?>">Signaler</a></li>
            </ul>
        </div>

        <form action="<?= BASE_PATH . 'book/show?id=' . $book['id']; ?>" method="POST" class="formCommentBook">
            <label for="comment" class="form-label">Vous avez lu et voulez partager votre avis sur le livre ?</label>
            <textarea name="comment" class="form-control" id="comment" rows="3" style="resize: none;"></textarea>
            <small><?= $error['comment'] ?? ""; ?></small>
            <button class="" type="submit">Envoyer</button>
        </form>
    </div>



    <div class="showBook-separator"></div>



    <div class="showBook-2 showBook-2-2">


        <div class="showBook-3 showBook-3-1">

            <div class="showBook-4 showBook-4-1">
                <span class="showBook-target"><?= $book['target_reader']; ?></span>
                <span class="showBook-status"><?= $book['status']; ?></span>
            </div>

            <div class="showBook-4 showBook-4-2">
                <div class="showBook-5 showBook-5-1">
                    <p><strong>Auteur: </strong><?= $book['author']; ?></p>
                    <p><strong>Editeur: </strong><?= $book['editor']; ?></p>
                    <p><strong>Publié en: </strong><?= $book['date_publication']; ?></p>
                    <?php if (isset($user['id']) && ($book['status'] != 'documentation')) : ?>
                        <a href="mailto:<?= $user['email']; ?>" class="btn darkGreen bg-lightGreen">Contacter <?= $user['pseudo']; ?></a>
                    <?php endif; ?>
                </div>
                <div class="showBook-5 showBook-5-2">
                    <p><?= $book['synopsis']; ?></p>
                </div>
            </div>

            <div class="showBook-4 showBook-4-3">
                <?php if (isset($user['id'])) : ?>
                    <div class="showBook-5-1">
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Delectus omnis quam est voluptas animi architecto expedita hic facere sed possimus necessitatibus odit iste corporis labore magnam molestias, excepturi perspiciatis odio?</p>
                    </div>
                    <a class="showBook-profile-1" href="<?= BASE_PATH . 'user/profile?id=' . $book['id_user']; ?>">
                        <img src="<?= BASE . 'upload/photos/profile/' . $user['photo_profile']; ?>" class="photoProfile" alt="Photo de profil">
                        <span>
                            <?= $user['pseudo']; ?>
                        </span>
                    </a>
                <?php endif; ?>
            </div>

        </div>


        <form action="<?= BASE_PATH . 'book/show?id=' . $book['id']; ?>" method="POST">
            <button type="submit" class="btn-deco-none" name="likes">
                <?php if (isset($_SESSION['user']) && ($likeFound && ($likeFound['likes'] == 1))) : ?>
                    <i class="fa-solid fa-heart"></i>
                <?php else : ?>
                    <i class="fa-regular fa-heart"></i>
                <?php endif; ?>
            </button>
            <?= $countLikes; ?>
        </form>


        <div class="showBook-3 showBook-3-2">
            <h2><?= $book['title']; ?></h2>
            <img src="<?= BASE . 'upload/book/' . $book['photo']; ?>" alt="Couverture de <?= $book['title']; ?>" height="400">
        </div>


        <div class="showBook-3 showBook-3-3">
            <?php foreach ($comments as $comment) : ?>
                <?php $otherCommentUser = User::findById(['id' => $comment['id_commentator']]); ?>
                <div class="showBook-comments">
                    <div class="showBook-profile-2">
                        <img class="roundProfile" src="<?= BASE . 'upload/photos/profile/' . $otherCommentUser['photo_profile']; ?>" alt="Photo de profil">
                        <p><?= $otherCommentUser['pseudo']; ?></p>
                    </div>
                    <p><?= $comment['comment']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>


    </div>



</div>
<?php include(VIEWS . '_partials/footer.php'); ?>