<?php include(VIEWS . '_partials/header.php'); ?>

<h1>Accueil</h1>

<?php if (isset($_SESSION['user'])) : ?>
    <!-- RECHERCHE -->
    <form action="<?= BASE_PATH; ?>" method="get" class="col-3">
        <input class="form-control" type="text" name="searchUser" id="" placeholder="@pseudo">
        <input class="btn bg-beige" type="submit" value="Rechercher">
        <a href="<?= BASE_PATH; ?>" class="btn bg-transparent border-warning">Réinitialiser</a>
    </form>

    <?php if (isset($_GET['searchUser'])) : ?>
        <ul>
            <?php foreach ($users as $user) : ?>
                <a href="<?= BASE_PATH . 'user/profile?id=' . $user['id']; ?>">
                    <?= $user['pseudo']; ?>
                </a>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
<?php endif; ?>

<?php include(VIEWS . '_partials/footer.php'); ?>