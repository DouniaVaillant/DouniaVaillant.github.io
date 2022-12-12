<?php include(VIEWS . '_partials/header.php');

if (!isset($_SESSION['user'])) {
    header('location:../');
    exit();
}

?>


<form method="POST" action="<?= BASE_PATH . "admin/user/add"; ?>">
    <div class="mb-3">
        <label for="lastname" class="form-label">Nom</label>
        <input name="lastname" value="<?= $_POST['lastname'] ?? ''; ?>" type="text" class="form-control" id="lastname" aria-describedby="emailHelp">
        <small class="text-danger"><?= $error['lastname'] ?? ""; ?></small>
    </div>

    <div class="mb-3">
        <label for="firstame" class="form-label">Prénom</label>
        <input name="firstname" value="<?= $_POST['firstname'] ?? ''; ?>" type="text" class="form-control" id="firstame" aria-describedby="emailHelp">
        <small class="text-danger"><?= $error['firstname'] ?? ""; ?></small>
    </div>

    <div class="mb-3">
        <label for="pseudo" class="form-label">Pseudo</label>
        <input name="pseudo" value="<?= $_POST['pseudo'] ?? ''; ?>" type="text" class="form-control" id="pseudo" aria-describedby="emailHelp">
        <small class="text-danger"><?= $error['pseudo'] ?? ""; ?></small>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input name="email" value="<?= $_POST['email'] ?? ''; ?>" type="email" class="form-control" id="email" aria-describedby="emailHelp">
        <small class="text-danger"><?= $error['email'] ?? ""; ?></small>
    </div>

    <div class="mb-3">
        <label for="birthday" class="form-label">Date de naissance</label>
        <input name="birthday" value="<?= $_POST['birthday'] ?? ''; ?>" type="date" class="form-control" id="birthday" aria-describedby="emailHelp">
        <small class="text-danger"><?= $error['birthday'] ?? ""; ?></small>
    </div>

    <div class="mb-3">
        <label for="way" class="form-label">Adresse (n° de voie)</label>
        <input name="way" value="<?= $_POST['way'] ?? ''; ?>" type="text" class="form-control" id="way" aria-describedby="emailHelp">
        <small class="text-danger"><?= $error['way'] ?? ""; ?></small>
    </div>

    <div class="mb-3">
        <label for="address" class="form-label">Adresse (voie)</label>
        <input name="address" value="<?= $_POST['address'] ?? ''; ?>" type="text" class="form-control" id="address" aria-describedby="emailHelp">
        <small class="text-danger"><?= $error['address'] ?? ""; ?></small>
    </div>

    <div class="mb-3">
        <label for="city" class="form-label">Ville</label>
        <input name="city" value="<?= $_POST['city'] ?? ''; ?>" type="text" class="form-control" id="city" aria-describedby="emailHelp">
        <small class="text-danger"><?= $error['city'] ?? ""; ?></small>
    </div>

    <div class="mb-3">
        <label for="postal_code" class="form-label">Code postal</label>
        <input name="postal_code" value="<?= $_POST['postal_code'] ?? ''; ?>" type="number" class="form-control" id="postal_code" aria-describedby="emailHelp">
        <small class="text-danger"><?= $error['postal_code'] ?? ""; ?></small>
    </div>

    <div class="mb-3">
        <label for="country" class="form-label">Pays</label>
        <input name="country" value="<?= $_POST['country'] ?? ''; ?>" type="text" class="form-control" id="country" aria-describedby="emailHelp">
        <small class="text-danger"><?= $error['country'] ?? ""; ?></small>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input name="password" value="<?= $_POST['password'] ?? ''; ?>" type="password" class="form-control" id="password">
        <small class="text-danger"><?= $error['password'] ?? ""; ?></small>
    </div>
    <div class="mb-3">
        <label for="confirmPassword" class="form-label">Confirmation du mot de passe</label>
        <input name="confirmPassword" value="<?= $_POST['confirmPassword'] ?? ''; ?>" type="password" class="form-control" id="confirmPassword">
        <small class="text-danger"><?= $error['confirmMdp'] ?? ''; ?></small>
    </div>
    <div class="form-check form-switch ms-4">
        <input class="form-check-input" onclick="showHidePassword(event)" type="checkbox" id="button">
        <label class="form-check-label" id="label" for="button">Afficher les mots de passe</label>
    </div>

    <div class="mb-3">
        <label for="gender" class="form-label">Genre</label>
        <select name="gender" value="<?= $_POST['gender'] ?? ''; ?>" class="form-select" aria-label="Default select example">
            <option selected>Selectionner</option>
            <option value="h">Homme</option>
            <option value="f">Femme</option>
            <option value="autre">Autre</option>
        </select>
        <small class="text-danger"><?= $error['gender'] ?? ""; ?></small>
    </div>

    <div class="mb-3">
        <label for="roles" class="form-label">Rôle</label>
        <input type="radio" name="roles" id="roles" value="ROLE_USER">Membre
        <input type="radio" name="roles" id="roles" value="ROLE_MODO">Modérateur.trice
        <input type="radio" name="roles" id="roles" value="ROLE_ADMIN">Administrateur.trice
        <small class="text-danger"><?= $error['roles'] ?? ""; ?></small>
    </div>
    <button type="submit" class="btn btn-primary">Ajouter</button>
</form>


<?php include(VIEWS . '_partials/footer.php'); ?>