<?php include(VIEWS . '_partials/header.php'); ?>

<div class="container-fluid mt-5">

    <form action="<?= BASE_PATH . 'admin/book/list'; ?>" method="GET" class="mt-4 col-lg-3">
        <select name="category" class="form-select">
            <?php foreach ($categories as $category) : ?>
                <option value="<?= $category['title']; ?>"><?= $category['title']; ?></option>
            <?php endforeach; ?>
        </select>
        <button class="btn btn-light border-warning" type="submit">Filtrer</button>
        <a href="<?= BASE_PATH . 'admin/book/list'; ?>" class="btn btn-light border-warning">Réinitialiser</a>
    </form>

    <!-- TABLEAU DES LIVRES -->
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Documenté par</th>
                <th>Couverture</th>
                <th>Titre</th>
                <th>Catégorie</th>
                <th>Cible</th>
                <th>Auteur</th>
                <th>Éditeur</th>
                <th>Statut</th>
                <th>Date de publication</th>
                <th>Documentation créée le</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book) :
                $user = User::findById(['id' => $book['id_user']]);
            ?>
                <tr class="bg-sun">
                    <th scope="row"><?= $book['id']; ?></th>
                    <td><?php echo $user['pseudo']; ?></td>
                    <td><img src="<?= BASE . 'upload/book/' . $book['photo']; ?>" alt="couverture" height="100"></td>
                    <td><?= $book['title']; ?></td>
                    <td><?= $book['category']; ?></td>
                    <td><?= $book['target_reader']; ?></td>
                    <td><?= $book['author']; ?></td>
                    <td><?= $book['editor']; ?></td>
                    <td><?= $book['status']; ?></td>
                    <td><?= $book['date_publication']; ?></td>
                    <td><?= $book['date_created']; ?></td>
                    <td>
                        <a href="<?= BASE_PATH . 'book/show?id=' . $book['id']; ?>" class=""><i class="fa-solid soil fa-eye"></i></a>
                        <a href="<?= BASE_PATH . 'admin/book/edit?id=' . $book['id']; ?>" class=""><i class="fa-solid soil fa-pen"></i></a>
                        <a onclick="return confirm('Etes-vous sûr de vouloir supprimer cette documentation ?')" href="<?= BASE_PATH . 'book/delete?id=' . $book['id']; ?>" class=""><i class="fa-solid soil fa-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>










</div>













<?php include(VIEWS . '_partials/footer.php'); ?>