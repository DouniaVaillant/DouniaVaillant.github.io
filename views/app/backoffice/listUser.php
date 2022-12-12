<?php include(VIEWS . '_partials/header.php'); ?>

<h1>Gestion des utilisateurs</h1>

<div class="container-fluid mt-5 pageListUser">


    <form action="<?= BASE_PATH . 'admin/user/list'; ?>" method="GET" class="mt-4 col-lg-3">
        <select name="roles" class="form-select">
            <option value="ROLE_USER">Membre</option>
            <option value="ROLE_ADMIN">Administrateur</option>
            <option value="ROLE_MODO">Modérateur</option>
        </select>
        <button class="btn btn-light border border-warning" type="submit">Filtrer</button>
        <a href="<?= BASE_PATH . 'admin/user/list'; ?>" class="btn btn-light border-warning">Réinitialiser</a>
    </form>

    <a href="<?= BASE_PATH . 'admin/user/add'; ?>" class="btn btn-warning mt-4">Ajouter un membre</a>

    <!-- TABLEAU DES UTILISATEURS -->
    <table class="table table-hover">

        <thead>
            <tr>
                <th>#</th>
                <th>Rôle</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Pseudo</th>
                <th>Email</th>
                <th>Genre</th>
                <th>Date de naissance</th>
                <?php if ($_SESSION['user']['roles'] == 'ROLE_ADMIN') : ?>
                    <th>N° de voie</th>
                    <th>Adresse</th>
                    <th>Ville</th>
                    <th>Code postal</th>
                <?php endif; ?>
                <th>Pays</th>
                <th>Date d'inscription</th>
                <th>Action</th>
            </tr>
        </thead>



        <tbody>
            <?php foreach ($users as $user) : ?>
                <tr class="<?php if ($user['roles'] == 'ROLE_ADMIN') : ?> text-light bg-lightGreen<?php elseif ($user['roles'] == 'ROLE_MODO') : ?>bg-lightBrown<?php elseif ($user['roles'] == 'ROLE_USER') : ?>bg-sun<?php endif; ?>">
                    <th scope="row"><?= $user['id']; ?></th>


                    <?php if ($user['roles'] == 'ROLE_USER') : ?>
                        <?php if ($user['gender'] == 'f') : ?>
                            <td>Utilisatrice</td>
                        <?php else : ?>
                            <td>Utilisateur</td>
                        <?php endif; ?>

                    <?php elseif ($user['roles'] == 'ROLE_ADMIN') : ?>
                        <?php if ($user['gender'] == 'f') : ?>
                            <td>Administratrice</td>
                        <?php else : ?>
                            <td>Administrateur</td>
                        <?php endif; ?>

                    <?php elseif ($user['roles'] == 'ROLE_MODO') : ?>
                        <?php if ($user['gender'] == 'f') : ?>
                            <td>Modératrice</td>
                        <?php else : ?>
                            <td>Modérateur</td>
                        <?php endif; ?>
                    <?php endif; ?>


                    <td><?= $user['lastname']; ?></td>

                    <td><?= $user['firstname']; ?></td>

                    <td><?= $user['pseudo']; ?></td>

                    <td><?= $user['email']; ?></td>

                    <?php if ($user['gender'] == 'h') : ?>
                        <td>Homme</td>
                    <?php elseif ($user['gender'] == 'f') : ?>
                        <td>Femme</td>
                    <?php else : ?>
                        <td>Autre</td>
                    <?php endif; ?>

                    <td><?= $user['birthday']; ?></td>

                    <?php if ($_SESSION['user']['roles'] == 'ROLE_ADMIN') : ?>
                        <td><?= $user['way']; ?></td>

                        <td><?= $user['address']; ?></td>

                        <td><?= $user['city']; ?></td>

                        <td><?= $user['postal_code']; ?></td>
                    <?php endif; ?>

                    <td><?= $user['country']; ?></td>

                    <td><?= $user['date_registration']; ?></td>

                    <td>
                        <a href="<?= BASE_PATH . 'user/profile?id=' . $user['id']; ?>" class=""><i class="fa-solid soil fa-eye"></i></a>
                        <?php if (($_SESSION['user']['roles'] != 'ROLE_ADMIN' && $user['roles'] == 'ROLE_USER') || $_SESSION['user']['roles'] == 'ROLE_ADMIN') : ?>
                            <a href="<?= BASE_PATH . 'admin/user/edit?id=' . $user['id']; ?>" class=""><i class="fa-solid soil fa-pen"></i></a>
                            <a onclick="return confirm('Etes-vous sûr de vouloir supprimer cet utilisateur ?')" href="<?= BASE_PATH . 'admin/user/delete?id=' . $user['id']; ?>" class=""><i class="fa-solid soil fa-trash"></i></a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>










</div>













<?php include(VIEWS . '_partials/footer.php'); ?>