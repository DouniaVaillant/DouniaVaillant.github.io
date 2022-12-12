<?php include(VIEWS . '_partials/header.php'); ?>


<form action="<?= BASE_PATH . 'user/logIn'; ?>" method="post" class="w-50 mx-auto border border-dark rounded p-5 mt-5">
    <h4 class="text-center">Connexion</h4>

    <div>
        <label for="email" class="form-label">Email</label>
        <input name="email" value="<?= $_POST['email'] ?? ''; ?>" type="text" class="form-control" id="email">
    </div>
    <div>
        <label for="password" class="form-label">Mot de passe</label>
        <input name="password"type="password" class="form-control" id="password">
    </div>
    <div class="form-check form-switch ms-4">
        <input class="form-check-input" type="checkbox" id="button">
        <label class="form-check-label" id="label" for="button">Afficher le mot de passe</label>
    </div>

    <button class="mt-4 btn btn-warning text-light" type="submit">Se connecter</button>

</form>



<script>
    // $ Afficher/masquer le mot de passe sur la connexion
    let passwordLogIn = document.getElementById("password");
    let button = document.getElementById("button");
    let label = document.getElementById("label");

    let passwordShow = function(event) {

        if (label.innerText === "Cacher le mot de passe") {
            passwordLogIn.setAttribute("type", "password");
            button.setAttribute("checked", false);
            label.innerText = "Afficher le mot de passe";
        } else {
            passwordLogIn.setAttribute("type", "text");
            button.setAttribute("checked", true);
            label.innerText = "Cacher le mot de passe";
        }
    };

    button.addEventListener('click', passwordShow);
</script>




<?php include(VIEWS . '_partials/footer.php'); ?>