<?php include(VIEWS . '_partials/header.php'); 

if (!isset($_SESSION['user'])) {
    header('location:../');
    exit();
}

?>

<form method="post" action="<?=  BASE_PATH.'user/editPassword' ; ?>" class="row g-3">

    <div class="col-md-12">
        <label for="oldPassword" class="form-label">Mot de passe actuel</label>
        <input name="actualMdp" value="<?=  $_POST['actualMdp'] ?? '' ; ?>" type="password" class="form-control" id="oldPassword">
        <small class="text-danger"><?=  $error['actualMdp'] ?? '' ; ?></small>
    </div>

    <div class="col-md-6">
        <label for="newPassword" class="form-label">Nouveau Mot de passe</label>
        <input name="password" value="<?=  $_POST['password'] ?? '' ; ?>" type="password" class="form-control" id="newPassword">
        <small class="text-danger"><?=  $error['password'] ?? '' ; ?></small>
    </div>
    <div class="col-md-6">
        <label for="confirmPassword" class="form-label">Confirmation du nouveau Mot de passe</label>
        <input name="confirmPassword" value="<?=  $_POST['confirmPassword'] ?? '' ; ?>" type="password" class="form-control" id="confirmPassword">
        <small class="text-danger"><?=  $error['confirmPassword'] ?? '' ; ?></small>
    </div>
    <div class="form-check form-switch ms-4">
        <input class="form-check-input" onclick="montrer(event)"  type="checkbox" id="button" >
        <label class="form-check-label" id="label" for="button">Afficher les mots de passe</label>
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary">Modifier</button>
    </div>
</form>


<script>

    let montrer= function (event)
    {
        let oldPassword= document.getElementById('oldPassword');
        let newPassword= document.getElementById('newPassword');
        let confirmPassword= document.getElementById('confirmPassword');
        let button=document.getElementById('button');
        let label=document.getElementById('label');

        if (label.innerText==='Cacher les mots de passe'){
            mdp1.setAttribute('type', 'password');
            newPassword.setAttribute('type', 'password');
            confirmPassword.setAttribute('type', 'password');
            button.setAttribute('checked', false);
            label.innerText='Afficher les mots de passe';


        }else{
            oldPassword.setAttribute('type', 'text');
            newPassword.setAttribute('type', 'text');
            confirmPassword.setAttribute('type', 'text');
            button.setAttribute('checked', true);
            label.innerText='Cacher les mots de passe';


        }





    }


</script>








<?php include(VIEWS.'_partials/footer.php'); ?>
