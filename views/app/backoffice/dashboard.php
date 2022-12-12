<?php include(VIEWS . '_partials/header.php'); ?>



<h1 id="dashboard-h1">Tableau de bord</h1>
<div class="pageDashboard">

    <ul>
        <li>
            <a href="<?= BASE_PATH . "admin/user/list"; ?>">Gestion des utilisateurs</a>
        </li>
        <li>
            <a href="<?= BASE_PATH . 'admin/story/list'; ?>">Gestion des Histoires numériques</a>
        </li>
        <li>
            <a href="<?= BASE_PATH . 'admin/book/list'; ?>">Gestion des Livres papiers</a>
        </li>
        <li>
            <a href="<?= BASE_PATH . 'admin/report/list'; ?>">Gestion des Signalements</a>
        </li>
        <li>
            <a href="#">Gestion des emprunts</a>
        </li>

        <?php if ($_SESSION['user']['roles'] == 'ROLE_ADMIN') : ?>
            <li>
                <a href="<?= BASE_PATH . 'admin/category/list'; ?>">Gestion des catégories</a>
            </li>
            <li>
                <a href="<?= BASE_PATH . 'admin/target-reader/list'; ?>">Gestion des cibles (lectorat)</a>
            </li>
        <?php endif; ?>
    </ul>

</div>






<?php include(VIEWS . '_partials/footer.php'); ?>