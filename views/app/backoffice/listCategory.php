<?php include(VIEWS . '_partials/header.php'); ?>




<a href="<?= BASE_PATH . 'admin/category/add'; ?>" class="btn btn-warning mt-4">Nouvelle Catégorie</a>

<table class="table table-hover text-center w-50">
    <thead>
        <tr>
            <!-- <th scope="col">#</th> -->
            <th scope="col">Titre</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $category) : ?>
            <tr>
                <!-- <th scope="row"><?= $category['id']; ?></th> -->
                <td><?= $category['title']; ?></td>
                <td>
                    <a href="<?= BASE_PATH . 'admin/category/edit?id=' . $category['id']; ?>"><i class="fas fa-edit soil"></i></a>
                    <a onclick="return confirm('Etes-vous sûr de vouloir supprimer cette catégorie ?')" href="<?= BASE_PATH . 'admin/category/delete?id=' . $category['id']; ?>"><i class="fas fa-trash soil"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>




















<?php include(VIEWS . '_partials/footer.php'); ?>