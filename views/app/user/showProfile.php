<?php include(VIEWS . '_partials/header.php');

if (!isset($_SESSION['user'])) {
    header('location:../');
    exit();
}

?>
<div class="" style="height: 20vh; overflow: hidden;">
    <img src="<?= BASE . 'upload/photos/banner/' . $user['photo_banner']; ?>" alt="Image de bannière" style="width: 100vw;">
</div>


<h1 class="text-center text-muted">@<?= $user['pseudo']; ?></h1>

<div class="" style="height: 100px; width: 100px; overflow: hidden; border-radius: 150px;">
    <img src="<?= BASE . 'upload/photos/profile/' . $user['photo_profile']; ?>" alt="Photo de profil" style="height: 200%;">
</div>

<p><?= $user['lastname']; ?></p>
<p><?= $user['firstname']; ?></p>
<p><?= $user['roles']; ?></p>
<p><?= $user['email']; ?></p>
<p><?= $user['way'] . " " . $user['address'] . " " . $user['city']; ?></p>
<p><?= $user['birthday']; ?></p>
<p><?= $user['gender']; ?></p>
<p><?= $user['date_registration']; ?></p>

<a class="btn btn-danger" href="<?= BASE_PATH . 'report?u=' . $user['id']; ?>">Signaler</a>

<?php if ($_SESSION['user']['roles'] == 'ROLE_ADMIN') : ?>
    <a href="<?= BASE_PATH . 'admin/user/edit?id=' . $user['id']; ?>" class="btn bg-lightGreen text-light">Modifier les informations de cet utilisateur</a>
    <a href="<?= BASE_PATH . 'admin/user/delete?id=' . $user['id']; ?>" class="btn bg-lightGreen text-light">Supprimer cet utilisateur</a>
<?php endif; ?>

















<?php include(VIEWS . '_partials/footer.php'); ?>