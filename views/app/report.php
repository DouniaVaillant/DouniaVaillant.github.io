<?php include(VIEWS . '_partials/header.php'); ?>

<?php if (isset($_GET['u'])) : ?>

    <h1>Signaler un utilisateur</h1>

    <form action="<?= BASE_PATH . 'report?u-reported=' . $_GET['u'] . '&u-reporter=' . $_SESSION['user']['id']; ?>" method="POST">
        <label for="user" class="form-label">Merci d'indiquer la raison de ce signalement de manière claire et concise</label>
        <textarea name="reason" id="user" class="form-control" placeholder="messages incitant à la haine, harcèlement ..."></textarea>

        <button type="submit" class="btn">Envoyer</button>
    </form>


<?php endif; ?>




<?php if (isset($_GET['s'])) : ?>

    <h1>Signaler une histoire numérique</h1>

    <form action="<?= BASE_PATH . 'report?s-reported=' . $_GET['s'] . '&u-reporter=' . $_SESSION['user']['id']; ?>" method="POST">

        <input type="radio" value="image de couverture" name="reason" id="cover">
        <label for="cover" >La couverture expose de la violence, nudité, haine</label>
        <br>
        <input type="radio" value="titre" name="reason" id="title">
        <label for="title">Le titre incite à la haine</label>
        <br>
        <input type="radio" value="mature" name="reason" id="mature">
        <label for="mature">N'est pas documenté comme mature et contient des éléments à caractère sexuels et/ou violents</label>
        <br>
        <input type="radio" value="contenu" name="reason" id="content">
        <label for="content">Propose un contenu incitant à la haine ou à la violence</label>
        <br>

        <button type="submit" class="btn">Envoyer</button>
    </form>


<?php endif; ?>





<?php if (isset($_GET['c'])) : ?>

    <h1>Signaler un chaptire</h1>

    <form action="<?= BASE_PATH . 'report?c-reported=' . $_GET['c'] . '&u-reporter=' . $_SESSION['user']['id']; ?>" method="POST">

        <input type="radio" value="titre" name="reason" id="title">
        <label for="title">Le titre incite à la haine</label>
        <br>
        <input type="radio" value="mature" name="reason" id="mature">
        <label for="mature">N'est pas documenté comme mature et contient des éléments à caractère sexuels et/ou violents</label>
        <br>
        <input type="radio" value="contenu" name="reason" id="content">
        <label for="content">Propose un contenu incitant à la haine ou à la violence</label>
        <br>
        <input type="radio" value="autre" name="reason" id="other">
        <label for="other">Autre</label>
        <br>

        <button type="submit" class="btn">Envoyer</button>
    </form>


<?php endif; ?>





<?php if (isset($_GET['b'])) : ?>

<h1>Signaler un livre</h1>

<form action="<?= BASE_PATH . 'report?b-reported=' . $_GET['b'] . '&u-reporter=' . $_SESSION['user']['id']; ?>" method="POST">

    <input type="radio" value="titre" name="reason" id="title">
    <label for="title">Le titre incite à la haine</label>
    <br>
    <input type="radio" value="mature" name="reason" id="mature">
    <label for="mature">N'est pas documenté comme mature et contient des éléments à caractère sexuels et/ou violents</label>
    <br>
    <input type="radio" value="contenu" name="reason" id="content">
    <label for="content">Propose un contenu incitant à la haine ou à la violence</label>
    <br>
    <input type="radio" value="autre" name="reason" id="other">
    <label for="other">Autre</label>
    <br>

    <button type="submit" class="btn">Envoyer</button>
</form>


<?php endif; ?>
















<?php include(VIEWS . '_partials/footer.php'); ?>