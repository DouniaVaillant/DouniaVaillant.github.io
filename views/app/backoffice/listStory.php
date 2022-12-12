<?php include(VIEWS . '_partials/header.php'); ?>

<div class="container-fluid mt-5">

    <form action="<?= BASE_PATH . 'admin/story/list'; ?>" method="GET" class="mt-4 col-lg-3">
        <select name="category" class="form-select">
            <?php foreach ($categories as $category) : ?>
                <option value="<?= $category['title']; ?>"><?= $category['title']; ?></option>
            <?php endforeach; ?>
        </select>
        <button class="btn btn-light border-warning" type="submit">Filtrer</button>
        <a href="<?= BASE_PATH . 'admin/story/list'; ?>" class="btn btn-light border-warning">Réinitialiser</a>
    </form>

    <!-- TABLEAU DES LIVRES -->
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Auteur</th>
                <th>Couverture</th>
                <th>Titre</th>
                <!-- <th>Nb de chapitre</th> -->
                <th>Catégorie</th>
                <th>Cible</th>
                <th>Statut</th>
                <th>Langue</th>
                <th>Créée le</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stories as $story) :
                $user = User::findById(['id' => $story['id_user']]);
            ?>
                <tr class="bg-sun">
                    <th scope="row"><?= $story['id']; ?></th>
                    <td><?php echo $user['pseudo']; ?></td>
                    <td><img src="<?= BASE . 'upload/story/' . $story['photo']; ?>" alt="couverture" height="100"></td>
                    <td><?= $story['title']; ?></td>
                    <!-- <td><?php $nbChapitre = Chapter::count(['id_story' => intval($story['id'])]); echo $nbChapitre; ?></td> -->
                    <td><?= $story['category']; ?></td>
                    <td><?= $story['target_reader']; ?></td>
                    <td><?= $story['status']; ?></td>
                    <td><?= $story['language']; ?></td>
                    <td><?= $story['date_created']; ?></td>
                    <td>
                        <a href="<?= BASE_PATH . 'story/show?id=' . $story['id']; ?>" class=""><i class="fa-solid soil fa-eye"></i></a>
                        <a href="<?= BASE_PATH . 'admin/story/edit?id=' . $story['id']; ?>" class=""><i class="fa-solid soil fa-pen"></i></a>
                        <a onclick="return confirm('Etes-vous sûr de vouloir supprimer cette histoire ?')" href="<?= BASE_PATH . 'story/delete?id=' . $story['id']; ?>" class=""><i class="fa-solid soil fa-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>


<?php include(VIEWS . '_partials/footer.php'); ?>