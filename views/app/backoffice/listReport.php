<?php include(VIEWS . '_partials/header.php'); ?>

<div class="container-fluid mt-5">

    <div class="filters" style="display: flex;">
        <form action="<?= BASE_PATH . 'admin/report/list'; ?>" method="GET" class="mx-2">
            <button class="btn btn-light border-warning" name="fixed" value="show" type="submit">Résolus</button>
        </form>
        <form action="<?= BASE_PATH . 'admin/report/list'; ?>" method="GET" class="mx-2">
            <button class="btn btn-light border-warning" name="list" value="user" type="submit">Membres</button>
        </form>
        <form action="<?= BASE_PATH . 'admin/report/list'; ?>" method="GET" class="mx-2">
            <button class="btn btn-light border-warning" name="list" value="book" type="submit">Livres</button>
        </form>
        <form action="<?= BASE_PATH . 'admin/report/list'; ?>" method="GET" class="mx-2">
            <button class="btn btn-light border-warning" name="list" value="story" type="submit">Histoires</button>
        </form>
        <form action="<?= BASE_PATH . 'admin/report/list'; ?>" method="GET" class="mx-2">
            <button class="btn btn-light border-warning" name="list" value="chapter" type="submit">Chapitres</button>
        </form>
        <a href="<?= BASE_PATH . 'admin/report/list'; ?>" class="mx-2 btn btn-light border-warning">Réinitialiser</a>
    </div>

    <?php if (isset($_GET['list'])) : ?>

        <!-- TABLEAU DES UTILISATEURS SIGNALES -->
        <?php if ($_GET['list'] == 'user') : ?>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Signalement de</th>
                        <th>Signalé</th>
                        <th>Raison</th>
                        <th>Etat</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($userReports as $report) :
                        $reporter = User::findById(['id' => $report['id_reporter']]);
                        $reported = User::findById(['id' => $report['id_reported']]);
                    ?>
                        <?php if ($report['fixed'] == 0) : ?>
                            <tr class="bg-sun">
                                <th scope="row"><?= $report['id']; ?></th>

                                <?php if ($reporter) : ?>
                                    <td><a href="<?= BASE_PATH . 'user/profile?id=' . $reporter['id']; ?>"><?= $reporter['pseudo']; ?></a></td>
                                <?php else : ?>
                                    <td>utilisateur supprimé ou inexistant</td>
                                <?php endif; ?>

                                <?php if ($reported) : ?>
                                    <td><a href="<?= BASE_PATH . 'user/profile?id=' . $reported['id']; ?>">#<?= $report['id_reported'] . ' ' . $reported['pseudo']; ?><br><?= $reported['email']; ?></a></td>
                                <?php else : ?>
                                    <td>utilisateur supprimé ou inexistant</td>
                                <?php endif; ?>

                                <td><?= $report['reason']; ?></td>

                                <td><?php if ($report['fixed'] == 0) {
                                        echo 'en attente de vérification';
                                    } elseif ($report['fixed'] == 1) {
                                        echo 'résolu';
                                    }; ?></td>

                                <td><?= $report['date_created']; ?></td>

                                <td>
                                    <form action="<?= BASE_PATH . 'admin/report/edit?id=' . $report['id']; ?>" method="post">
                                        <button name="fixed" type="submit" class="btn-deco-none"><i class="fa-solid fa-check"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php endif; ?>




        <!-- TABLEAU DES LIVRES SIGNALES -->
        <?php if ($_GET['list'] == 'book') : ?>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Signalement de</th>
                        <th>Livre signalé</th>
                        <th>Raison</th>
                        <th>Etat</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($bookReports as $report) :
                        $reporter = User::findById(['id' => $report['id_reporter']]);
                        $book = Book::findById(['id' => $report['id_book']]);
                    ?>
                        <?php if ($report['fixed'] == 0) : ?>
                            <tr class="bg-sun">
                                <th scope="row"><?= $report['id']; ?></th>

                                <?php if ($reporter) : ?>
                                    <td><a href="<?= BASE_PATH . 'user/profile?id=' . $reporter['id']; ?>"><?= $reporter['pseudo']; ?></a></td>
                                <?php else : ?>
                                    <td><i>utilisateur supprimé ou inexistant</i></td>
                                <?php endif; ?>

                                <?php if ($book) : ?>
                                    <td><a href="<?= BASE_PATH . 'book/show?id=' . $book['id']; ?>">#<?= $report['id_book']; ?><br><?= $book['title']; ?></a></td>
                                <?php else : ?>
                                    <td><i>Supprimé ou inexistant</i></td>
                                <?php endif; ?>

                                <td><?= $report['reason']; ?></td>

                                <td><?php if ($report['fixed'] == 0) {
                                        echo 'en attente de vérification';
                                    } elseif ($report['fixed'] == 1) {
                                        echo 'résolu';
                                    }; ?></td>

                                <td><?= $report['date_created']; ?></td>

                                <td>
                                    <form action="<?= BASE_PATH . 'admin/report/edit?id=' . $report['id']; ?>" method="post">
                                        <button name="fixed" type="submit" class="btn-deco-none"><i class="fa-solid fa-check"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php endif; ?>




        <!-- TABLEAU DES HISTOIRES SIGNALES -->
        <?php if ($_GET['list'] == 'story') : ?>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Signalement de</th>
                        <th>Histoire signalé</th>
                        <th>Raison</th>
                        <th>Etat</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($storyReports as $report) :
                        $reporter = User::findById(['id' => $report['id_reporter']]);
                        $story = Story::findById(['id' => $report['id_story']]);
                    ?>
                        <?php if ($report['fixed'] == 0) : ?>
                            <tr class="bg-sun">
                                <th scope="row"><?= $report['id']; ?></th>

                                <?php if ($reporter) : ?>
                                    <td><a href="<?= BASE_PATH . 'user/profile?id=' . $reporter['id']; ?>"><?= $reporter['pseudo']; ?></a></td>
                                <?php else : ?>
                                    <td><i>Utilisateur supprimé ou inexistant</i></td>
                                <?php endif; ?>

                                <?php if ($story) : ?>
                                    <td><a href="<?= BASE_PATH . 'story/show?id=' . $story['id']; ?>">#<?= $report['id_story']; ?><br><?= $story['title']; ?></a></td>
                                <?php else : ?>
                                    <td><i>Supprimé ou inexistant</i></td>
                                <?php endif; ?>

                                <td><?= $report['reason']; ?></td>

                                <td><?php if ($report['fixed'] == 0) {
                                        echo 'en attente de vérification';
                                    } elseif ($report['fixed'] == 1) {
                                        echo 'résolu';
                                    }; ?></td>

                                <td><?= $report['date_created']; ?></td>

                                <td>
                                    <form action="<?= BASE_PATH . 'admin/report/edit?id=' . $report['id']; ?>" method="post">
                                        <button name="fixed" type="submit" class="btn-deco-none"><i class="fa-solid fa-check"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php endif; ?>




        <!-- TABLEAU DES CHAPITRES SIGNALES -->
        <?php if ($_GET['list'] == 'chapter') : ?>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Signalement de</th>
                        <th>Histoire</th>
                        <th>Chapitre signalé</th>
                        <th>Raison</th>
                        <th>Etat</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($chapterReports as $report) :
                        $reporter = User::findById(['id' => $report['id_reporter']]);
                        $chapter = Chapter::findById(['id' => $report['id_chapter']]);
                        $story = Story::findById(['id' => $chapter['id_story']]);
                    ?>
                        <?php if ($report['fixed'] == 0) : ?>
                            <tr class="bg-sun">
                                <th scope="row"><?= $report['id']; ?></th>

                                <?php if ($reporter) : ?>
                                    <td><a href="<?= BASE_PATH . 'user/profile?id=' . $reporter['id']; ?>"><?= $reporter['pseudo']; ?></a></td>
                                <?php else : ?>
                                    <td><i>Utilisateur supprimé ou inexistant</i></td>
                                <?php endif; ?>

                                <?php if ($story) : ?>
                                    <td><a href="<?= BASE_PATH . 'story/show?id=' . $story['id']; ?>">#<?= $story['id']; ?><br><?= $story['title']; ?></a></td>
                                <?php else : ?>
                                    <td><i>Supprimé ou inexistant</i></td>
                                <?php endif; ?>

                                <?php if ($chapter) : ?>
                                    <td><a href="<?= BASE_PATH . 'story/chapter/show?id=' . $chapter['id']; ?>">#<?= $chapter['id']; ?><br><?= $chapter['title']; ?></a></td>
                                <?php else : ?>
                                    <td><i>Supprimé ou inexistant</i></td>
                                <?php endif; ?>

                                <td><?= $report['reason']; ?></td>

                                <td><?php if ($report['fixed'] == 0) {
                                        echo 'en attente de vérification';
                                    } elseif ($report['fixed'] == 1) {
                                        echo 'résolu';
                                    }; ?></td>

                                <td><?= $report['date_created']; ?></td>

                                <td>
                                    <form action="<?= BASE_PATH . 'admin/report/edit?id=' . $report['id']; ?>" method="POST">
                                        <button name="fixed" type="submit" class="btn-deco-none"><i class="fa-solid fa-check"></i></button>
                                    </form>
                                    <form action="<?= BASE_PATH . 'admin/report/ban?id=' . $report['id']; ?>" method="POST">
                                        <button name="fixed" type="submit" class="btn-deco-none"><i class="fa-solid fa-ban"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php endif; ?>


    <?php else : ?>
        <div class="alert alert-dismissible alert-warning m-1">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <h4 class="alert-heading">Information</h4>
            <p class="mb-0">
                Dans cette page est recensé les différents signalements, une fois le signalement vérifié et résolu il faut le marqué comme vérifié ("<i class="fa-solid fa-check"></i>") ou à bannir ("<i class="fa-solid fa-ban"></i>").
                <br>
                "<u>image de couverture</u>" => Image susceptible de choquer
                <br>
                "<u>titre</u>" => Le titre a été interprété comme offusquant (peut être du racisme, discrimination ...)
                <br>
                "<u>contenu</u>" => contenu inapproprié /!\ Si le livre / chapitre est indiqué et documenté comme "mature" (pouvant heurter la sensibilité de certains) et ne promeut pas la haine, il peut être marqué comme non-sanctionné.
                <br>
                "<u>mature</u>" => Propose un contenu mature sans être documenté comme tel
                <br>
                "<u>autre</u>" => indéfini précedemment il faut tout regarder
                <br>
            </p>
        </div>

    <?php endif; ?>





</div>













<?php include(VIEWS . '_partials/footer.php'); ?>