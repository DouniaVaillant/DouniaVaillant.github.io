<?php include(VIEWS . '_partials/header.php'); ?>




<a href="<?= BASE_PATH . 'admin/target-reader/add'; ?>" class="btn btn-warning mt-4">Ajouter une cible</a>

<table class="table table-hover text-center w-50">
    <thead>
        <tr>
            <th scope="col">Tranche d'âge</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($targetReader as $target) : ?>
            <tr>
                <td><?= $target['title']; ?></td>
                <td>
                    <a href="<?= BASE_PATH . 'admin/target-reader/edit?id=' . $target['id']; ?>"><i class="fas fa-edit soil"></i></a>
                    <a onclick="return confirm('Etes-vous sûr de vouloir supprimer cette cible ?')" href="<?= BASE_PATH . 'admin/target-reader/delete?id=' . $target['id']; ?>"><i class="fas fa-trash soil"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>




















<?php include(VIEWS . '_partials/footer.php'); ?>