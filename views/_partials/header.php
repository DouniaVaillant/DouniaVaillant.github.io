<!doctype html>
<html lang="en">

<head>
    <title><?= CONFIG['app']['name'] ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="<?= BASE . 'assets/images/logo.svg'; ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.2/css/bootstrap.min.css" integrity="sha512-CpIKUSyh9QX2+zSdfGP+eWLx23C8Dj9/XmHjZY2uDtfkdLGo0uY12jgcnkX9vXOgYajEKb/jiw67EYm+kBf+6g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= BASE . 'assets/css/style.css'; ?>">

</head>

<body>

    <nav class="navbar navbar-expand-lg bg-beige">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= BASE_PATH; ?>">
                <img src="<?= BASE . "assets/images/logo.svg"; ?>" alt="Logo_light" style="height: 70px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_PATH; ?>">Accueil</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="<?= BASE_PATH . 'books'; ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Livres papiers
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= BASE_PATH . 'books?status=partage'; ?>">Au partage</a></li>
                            <li><a class="dropdown-item" href="<?= BASE_PATH . 'books?status=don'; ?>">Au don</a></li>
                            <li><a class="dropdown-item" href="<?= BASE_PATH . 'books?status=documentation'; ?>">Documentés</a></li>
                            <li><a class="dropdown-item" href="<?= BASE_PATH . 'books'; ?>">Tous</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_PATH . 'stories'; ?>">Histoires numériques</a>
                    </li>
                    <?php if (isset($_SESSION['user'])) : ?>
                        <form class="d-flex" role="search">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="searchNav">
                            <button class="btn btn-outline-success" type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_PATH . 'library'; ?>">
                                <img src="<?= BASE . "assets/images/library.svg"; ?>" alt="Icone-bibliothèque" style="height: 30px;">
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['user'])) : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <!-- <img class="roundProfile" src="<?= BASE . 'upload/photos/profile/' . $_SESSION['user']['photo_profile']; ?>" alt="Photo-de-profil" style="height: 30px; width: 30px;"> -->
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= BASE_PATH . "user/profile"; ?>"> Profil</a></li>
                                <hr class="hr">
                                <li><a class="dropdown-item" href="<?= BASE_PATH . 'user/stories'; ?>">Mes histoires</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_PATH . 'user/books'; ?>">Mes livres</a></li>
                                <li><a class="dropdown-item" href="#">Mes emprunts</a></li>
                                <hr class="hr">
                                <li><a class="dropdown-item" href="<?= BASE_PATH . 'book/add'; ?>">Ajouter un livre</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_PATH . 'story/add'; ?>">Créer une histoire</a></li>
                                <hr class="hr">
                                <li><a class="dropdown-item" href="#">Paramètres</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_PATH . "user/logOut"; ?>">Déconnexion</a></li>
                            </ul>
                        </li>
                        <?php if ($_SESSION['user']['roles'] == 'ROLE_ADMIN' || $_SESSION['user']['roles'] == 'ROLE_MODO') : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= BASE_PATH . "admin/backoffice"; ?>">BACKOFFICE</a>
                            </li>
                        <?php endif; ?>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_PATH . "user/registration"; ?>">Inscription</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_PATH . "user/logIn"; ?>">Connexion</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container-fluid mt-4">
        <!-- <div class="position-relative text-center position-absolute z-index-2"> -->

            <?php if (isset($_SESSION['messages'])) :
                foreach ($_SESSION['messages'] as $type => $messages) :
                    foreach ($messages as $message) :
            ?>
                        <div class="w-50 text-center mx-auto alert alert-<?= $type ?>"><?= $message; ?></div>

            <?php endforeach;
                endforeach;
                unset($_SESSION['messages']);
            endif; ?>
        <!-- </div> -->