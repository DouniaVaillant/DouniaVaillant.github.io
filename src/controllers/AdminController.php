<?php

class AdminController
{


    // $ BACKOFFICE
    public static function index()
    {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['roles'] != 'ROLE_ADMIN' && $_SESSION['user']['roles'] != 'ROLE_MODO')) { // ? Sécurité
            header('location:../404.php');
            exit();
        }

        include(VIEWS . "app/backoffice/dashboard.php");
    }

    public static function listUser()
    {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['roles'] != 'ROLE_ADMIN' && $_SESSION['user']['roles'] != 'ROLE_MODO')) { // ? Sécurité
            header('location:../../404.php');
            exit();
        }

        $users = User::findAll();

        if (isset($_GET['roles'])) {
            $users = User::findByRole(['role' => $_GET['roles']]);
        }

        include(VIEWS . "app/backoffice/listUser.php");
    }

    public static function listBook()
    {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['roles'] != 'ROLE_ADMIN' && $_SESSION['user']['roles'] != 'ROLE_MODO')) { // ? Sécurité
            header('location:../../404.php');
            exit();
        }

        $books = Book::findAll();
        $categories = Category::findAll();

        if (isset($_GET['category'])) {
            $books = Book::findByCategory(['category' => $_GET['category']]);
        }

        include(VIEWS . "app/backoffice/listBook.php");
    }

    public static function listStory()
    {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['roles'] != 'ROLE_ADMIN' && $_SESSION['user']['roles'] != 'ROLE_MODO')) { // ? Sécurité
            header('location:../../404.php');
            exit();
        }

        $stories = Story::findAll();
        // foreach ($stories as $story) {
        //   $count = Chapter::count(['id_story' => intval($story['id'])]);
        // }

        $categories = Category::findAll();

        if (isset($_GET['category'])) {
            $stories = Story::findByCategory(['category' => $_GET['category']]);
        }

        include(VIEWS . "app/backoffice/listStory.php");
    }

    public static function listCategory()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['roles'] != 'ROLE_ADMIN') { // ? Sécurité
            header('location:../../404.php');
            exit();
        }

        $categories = Category::findAll();


        include(VIEWS . "app/backoffice/listCategory.php");
    }

    public static function listTargetReader()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['roles'] != 'ROLE_ADMIN') { // ? Sécurité
            header('location:../../404.php');
            exit();
        }

        $targetReader = TargetReader::findAll();


        include(VIEWS . "app/backoffice/listTargetReader.php");
    }

    public static function listReport()
    {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['roles'] != 'ROLE_ADMIN' && $_SESSION['user']['roles'] != 'ROLE_MODO')) { // ? Sécurité
            header('location:../../404.php');
            exit();
        }

        $userReports = Report::findUser();
        $bookReports = Report::findBook();
        $storyReports = Report::findStory();
        $chapterReports = Report::findChapter();

        include(VIEWS . "app/backoffice/listReport.php");
    }

    // $ CRUD user
    public static function addUser()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['roles'] != 'ROLE_ADMIN') { // ? Sécurité
            header('location:../../404.php');
            exit();
        }

        // Valeur par défaut:
        if (empty($_POST['pseudo'])) {
            $pseudo = 'pseudo' . random_int(99, 1111);
        } else {
            $pseudo = $_POST['pseudo'];
        }

        $error = [];
        if (!empty($_POST)) {

            function valid_pass($candidate)
            { // ? Vérif du mot de passe
                $r1 = '/[A-Z]/';  //Uppercase
                $r2 = '/[a-z]/';  //lowercase
                $r3 = '/[!@#$%^&*()\-_=+{};:,<.>]/';  // whatever you mean by 'special char'
                $r4 = '/[0-9]/';  //numbers

                if (preg_match_all($r1, $candidate, $o) < 1) return FALSE;
                if (preg_match_all($r2, $candidate, $o) < 1) return FALSE;
                if (preg_match_all($r3, $candidate, $o) < 1) return FALSE;
                if (preg_match_all($r4, $candidate, $o) < 1) return FALSE;
                if (strlen($candidate) < 8) return FALSE;

                return TRUE;
            }

            if (empty($_POST['lastname']) || preg_match('#[0-9]#', $_POST['lastname'])) {
                $error['lastname'] = 'Le champs est obligatoire et doit contenir uniquement des lettres';
            }

            if (empty($_POST['firstname']) || preg_match('#[0-9]#', $_POST['firstname'])) {
                $error['firstname'] = 'Le champs est obligatoire et doit contenir uniquement des lettres';
            }

            if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || User::findByEmail(['email' => $_POST['email']])) :
                if (User::findByEmail(['email' => $_POST['email']])) :
                    $_SESSION['messages']['danger'][] = 'Un compte est déjà existant à cette adresse mail, veuillez procéder à la récupération de mot passe';
                    $error['email'] = '';
                else :
                    $error['email'] = 'Le champs est obligatoire et l\'adresse mail doit être valide';
                endif;
            endif;

            if (empty($_POST['password']) || !valid_pass($_POST['password'])) :
                $error['password'] = 'Le mot de passe doit faire plus de 8 caractères et contenir majuscule, minuscule, chiffre et au moins un caractère spécial';
            endif;

            if (empty($_POST['birthday']) || preg_match('#[a-zA-Z]#', $_POST['birthday'])) {
                $error['birthday'] = 'Veuillez remplir correctement ce champs au format jj/mm/aaaa, aucune lettre n\'est acceptée';
            }

            if (empty($_POST['way'])) {
                $error['way'] = 'Le champs est obligatoire';
            }

            if (empty($_POST['address']) || preg_match('#[0-9]#', $_POST['address'])) {
                $error['address'] = 'Le champs est obligatoire est ne peut pas contenir de chiffre';
            }

            if (empty($_POST['city']) || preg_match('#[0-9]#', $_POST['city'])) {
                $error['city'] = 'Le champs est obligatoire est ne peut pas contenir de chiffre';
            }

            if (empty($_POST['postal_code']) || !preg_match('#^[0-9]{5}$#', $_POST['postal_code'])) {
                $error['postal_code'] = 'Le champs est obligatoire';
            }

            if (empty($_POST['country']) || preg_match('#[0-9]#', $_POST['country'])) {
                $error['country'] = 'Le champs est obligatoire';
            }

            if (empty($_POST['gender']) || preg_match('#[0-9]#', $_POST['gender'])) {
                $error['gender'] = 'Le champs est obligatoire';
            }

            if (empty($error)) : /// Si toutes les infos ont été validées
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

                User::create([ // ? Envoi des informations au modèle
                    'roles' => $_POST['roles'],
                    'lastname' => $_POST['lastname'],
                    'firstname' => $_POST['firstname'],
                    'pseudo' => $pseudo,
                    'email' => $_POST['email'],
                    'password' => $password,
                    'birthday' => $_POST['birthday'],
                    'way' => $_POST['way'],
                    'address' => $_POST['address'],
                    'city' => $_POST['city'],
                    'postal_code' => $_POST['postal_code'],
                    'country' => $_POST['country'],
                    'gender' => $_POST['gender']
                ]);

                $_SESSION['messages']['success'][] = "Création d'un nouvel utilisateur réalisée avec succès !";
                header('location:../user/list');
                exit();
            endif;
        }

        include(VIEWS . "app/backoffice/addUser.php");
    }

    public static function editUser()
    {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['roles'] != 'ROLE_ADMIN' && $_SESSION['user']['roles'] != 'ROLE_MODO')) { // ? Sécurité
            header('location:../../404.php');
            exit();
        }

        $user = User::findById(['id' => $_GET['id']]);

        // die(var_dump($_SESSION['user']['roles']));
        if ($_SESSION['user']['roles'] != 'ROLE_ADMIN' && ($user['roles'] == 'ROLE_ADMIN' || $user['roles'] == 'ROLE_MODO')) {
            $_SESSION['messages']['danger'][] = "Impossible pour un modérateur de modifier les informations d'un administrateur ou d'un autre modérateur";
            header('location:../user/list');
            exit();
        } else {

            $error = [];
            if (!empty($_POST)) {

                // * Bannière
                if (!empty($_FILES['photoBannerUpdate']['name']) && $_FILES['photoBannerUpdate']['size'] < 3000000 && ($_FILES['photoBannerUpdate']['type'] == 'image/jpeg' || $_FILES['photoBannerUpdate']['type'] == 'image/png' || $_FILES['photoBannerUpdate']['type'] == 'image/gif')) :

                    $extensionBannerUpload = strtolower(strchr($_FILES['photoBannerUpdate']['name'], '.')); /// = srttolower => met en minuscule ||| substr => ignore un élément de la chaîne ||| strrchr => récupère l'extension du fichier
                    $photoBannerName = $user['id'] . '-banner-' . date_format(new DateTime(), 'YdmHi') . '-' . uniqid() . $extensionBannerUpload;

                    unlink(PUBLIC_FOLDER . 'upload/photos/banner/' . $_POST['photo_banner']); // ? Suppression de la précédente image
                    copy($_FILES['photoBannerUpdate']['tmp_name'], PUBLIC_FOLDER . 'upload/photos/banner/' . $photoBannerName); // ? Copie de la nouvelle image dans le dossier concerné

                else :

                    $photoName = $_POST['photo_banner'];

                endif;

                // * Profile
                if (!empty($_FILES['photoProfileUpdate']['name']) && $_FILES['photoProfileUpdate']['size'] < 3000000 && ($_FILES['photoProfileUpdate']['type'] == 'image/jpeg' || $_FILES['photoProfileUpdate']['type'] == 'image/png' || $_FILES['photoProfileUpdate']['type'] == 'image/gif')) :

                    $extensionPhotoUpload = strtolower(strchr($_FILES['photoProfileUpdate']['name'], '.')); /// = srttolower => met en minuscule ||| substr => ignore un élément de la chaîne ||| strrchr => récupère l'extension du fichier
                    $photoName = $user['id'] . '-profile-' . date_format(new DateTime(), 'YdmHi') . '-' . uniqid() . $extensionPhotoUpload;

                    // on supprime la précédente photo grace à la méthode unlink qui attend en argument le chemin complet d'acces au fichier à supprimer
                    unlink(PUBLIC_FOLDER . 'upload/photos/profile/' . $_POST['photo_profile']);
                    // on copie dans notre dossier d'upload le fichier chargé et renommé
                    copy($_FILES['photoProfileUpdate']['tmp_name'], PUBLIC_FOLDER . 'upload/photos/profile/' . $photoName);

                else :

                    $photoName = $_POST['photo_profile'];

                endif;

                // * 
                if (empty($_POST['lastname']) || preg_match('#[0-9]#', $_POST['lastname'])) {
                    $error['lastname'] = 'Le champs est obligatoire et doit contenir uniquement des lettres';
                }

                if (empty($_POST['firstname']) || preg_match('#[0-9]#', $_POST['firstname'])) {
                    $error['firstname'] = 'Le champs est obligatoire et doit contenir uniquement des lettres';
                }

                if (empty($_POST['pseudo'])) {
                    $error['pseudo'] = 'Le champs est obligatoire';
                }

                // * Email
                if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || User::findByEmail(['email' => $_POST['email']])) :
                    if ($_POST['email'] == $user['email']) :

                    elseif (User::findByEmail(['email' => $_POST['email']])) :
                        $_SESSION['messages']['danger'][] = 'Un compte est déjà existant à cette adresse mail, veuillez procéder à la récupération de mot passe';
                        $error['email'] = '';

                    else :
                        $error['email'] = 'Le champs est obligatoire et l\'adresse mail doit être valide';
                    endif;
                endif;

                // * 
                if (empty($_POST['birthday']) || preg_match('#[a-zA-Z]#', $_POST['birthday'])) {
                    $error['birthday'] = 'Veuillez remplir correctement ce champs au format jj/mm/aaaa, aucune lettre n\'est acceptée';
                }

                if (empty($_POST['way'])) {
                    $error['way'] = 'Le champs est obligatoire';
                }

                if (empty($_POST['address']) || preg_match('#[0-9]#', $_POST['address'])) {
                    $error['address'] = 'Le champs est obligatoire est ne peut pas contenir de chiffre';
                }

                if (empty($_POST['city']) || preg_match('#[0-9]#', $_POST['city'])) {
                    $error['city'] = 'Le champs est obligatoire est ne peut pas contenir de chiffre';
                }

                if (empty($_POST['postal_code']) || !preg_match('#^[0-9]{5}$#', $_POST['postal_code'])) {
                    $error['postal_code'] = 'Le champs est obligatoire';
                }

                if (empty($_POST['country']) || preg_match('#[0-9]#', $_POST['country'])) {
                    $error['country'] = 'Le champs est obligatoire';
                }

                if (empty($_POST['gender']) || preg_match('#[0-9]#', $_POST['gender'])) {
                    $error['gender'] = 'Le champs est obligatoire';
                }

                if (empty($error)) :

                    User::update([
                        'photo_banner' => $photoBannerName,
                        'photo_profile' => $photoName,
                        'lastname' => $_POST['lastname'],
                        'firstname' => $_POST['firstname'],
                        'pseudo' => $_POST['pseudo'],
                        'email' => $_POST['email'],
                        'birthday' => $_POST['birthday'],
                        'way' => $_POST['way'],
                        'address' => $_POST['address'],
                        'city' => $_POST['city'],
                        'postal_code' => $_POST['postal_code'],
                        'country' => $_POST['country'],
                        'gender' => $_POST['gender'],
                        'roles' => $_POST['roles'],
                        'id' => $user['id']
                    ]);

                    $sessionUser = User::findById(['id' => $_SESSION['user']['id']]);
                    $_SESSION['user'] = $sessionUser;
                    $_SESSION['messages']['success'][] = 'Modification effectuée avec succès!';
                    header('location:../user/list');
                    exit();

                endif;
            }
        }

        include(VIEWS . "app/backoffice/editUser.php");
    }

    public static function deleteUser()
    {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['roles'] != 'ROLE_ADMIN' && $_SESSION['user']['roles'] != 'ROLE_MODO')) { // ? Sécurité
            header('location:../../404.php');
            exit();
        }

        if (!empty($_GET['id'])) :
            $userToDelete = User::findById(['id' => $_GET['id']]);
            // die(var_dump($_SESSION['user']['roles']));
            if ($_SESSION['user']['roles'] != 'ROLE_ADMIN' && ($userToDelete['roles'] == 'ROLE_ADMIN' || $userToDelete['roles'] == 'ROLE_MODO')) {
                $_SESSION['messages']['danger'][] = "Impossible pour un modérateur de supprimer un administrateur/modérateur";
                header('location:../user/list');
                exit();
            } else {
                unlink(PUBLIC_FOLDER . 'upload/photos/profile/' . $userToDelete['photo_profile']);
                unlink(PUBLIC_FOLDER . 'upload/photos/banner/' . $userToDelete['photo_banner']);
                User::delete([
                    'id' => intval($_GET['id'])
                ]);

                $_SESSION['messages']['success'][] = 'Utilisateur supprimé avec succès';

                header('location:../user/list');
                exit();
            }
        endif;
    } // ° Permettre au MODO de delete un utilisateur ??

    // $ CRUD book
    public static function editBook()
    {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['roles'] != 'ROLE_ADMIN' && $_SESSION['user']['roles'] != 'ROLE_MODO')) { // ? Sécurité
            header('location:../../404.php');
            exit();
        }

        if (!empty($_GET['id'])) {
            $book = Book::findById(['id' => $_GET['id']]);
        }

        $categories = Category::findAll();
        $targetReader = TargetReader::findAll();

        $error = [];
        if (!empty($_POST)) :
            // die(var_dump($book));

            $user = $_POST['id_user'];
            $category = $_POST['category'];
            $editor = $_POST['editor'];

            // * Couverture
            if (!empty($_FILES['photoCoverUpdate']['name']) && $_FILES['photoCoverUpdate']['size'] < 3000000 && ($_FILES['photoCoverUpdate']['type'] == 'image/jpeg' || $_FILES['photoCoverUpdate']['type'] == 'image/png' || $_FILES['photoCoverUpdate']['type'] == 'image/gif')) :
                $extensionPhoto = strtolower(strchr($_FILES['photoCoverUpdate']['name'], '.')); /// = srttolower => met en minuscule ||| substr => ignore un élément de la chaîne ||| strrchr => récupère l'extension du fichier
                $photoCoverName = $user . '-' . $book['id'] . '-' . preg_replace('/[^a-zA-Z\d\àâçéèîïìñôöùûü]+/', '', $_POST['title']) . $extensionPhoto;

                unlink(PUBLIC_FOLDER . 'upload/book/' . $_POST['photo']); // ? Suppression de la précédente image
                copy($_FILES['photoCoverUpdate']['tmp_name'], PUBLIC_FOLDER . 'upload/book/' . $photoCoverName); // ? Copie de la nouvelle image dans le dossier concerné
            else :
                $photoCoverName = $_POST['photo'];
            endif;

            // * 
            if (empty($_POST['title'])) {
                $error['title'] = 'Le champs est obligatoire';
            }

            if (empty($_POST['synopsis'])) {
                $error['synopsis'] = 'Le champs est obligatoire';
            }

            if (empty($_POST['author'])) {
                $error['author'] = 'Le champs est obligatoire';
            }

            if (empty($_POST['date_publication']) || preg_match('#[a-zA-Z]#', $_POST['date_publication'])) {
                $error['date_publication'] = 'Veuillez remplir correctement ce champs au format AAAA, aucune lettre n\'est acceptée';
            }

            if (empty($category)) {
                $error['category'] = 'Le champs est obligatoire';
            }

            if (empty($_POST['target_reader'])) {
                $error['target_reader'] = 'Le champs est obligatoire';
            }

            if (empty($_POST['status'])) {
                $error['status'] = 'Le champs est obligatoire';
            }

            if (empty($_POST['editor'])) {
                $editor = NULL;
            }

            // die(var_dump($_POST));
            if (empty($error)) :
                // die(var_dump($_POST));
                Book::update([
                    'id_user' => $user,
                    'category' => $category,
                    'target_reader' => $_POST['target_reader'],
                    'title' => $_POST['title'],
                    'author' => $_POST['author'],
                    'synopsis' => $_POST['synopsis'],
                    'photo' => $photoCoverName,
                    'editor' => $editor,
                    'date_publication' => $_POST['date_publication'],
                    'status' => $_POST['status'],
                    'id' => intval($book['id'])
                ]);

                $_SESSION['messages']['success'][] = 'Modification effectuée avec succès !';
                header('location:../book/list');
                exit();

            endif;

        endif;

        include(VIEWS . "app/backoffice/editBook.php");
    }

    // $ CRUD story
    public static function editStory()
    {

        if (!empty($_GET['id'])) {
            $story = Story::findById(['id' => $_GET['id']]);
        }
        $categories = Category::findAll();
        $targetReader = TargetReader::findAll();
        $user = $_SESSION['user'];

        $error = [];
        if (!empty($_POST)) :

            if (!empty($_FILES['photoCoverUpdate']['name']) && $_FILES['photoCoverUpdate']['size'] < 3000000 && ($_FILES['photoCoverUpdate']['type'] == 'image/jpeg' || $_FILES['photoCoverUpdate']['type'] == 'image/png' || $_FILES['photoCoverUpdate']['type'] == 'image/gif')) :
                $extensionPhoto = strtolower(strchr($_FILES['photoCoverUpdate']['name'], '.')); /// = srttolower => met en minuscule ||| substr => ignore un élément de la chaîne ||| strrchr => récupère l'extension du fichier
                $photoCoverName = $story['id_user'] . '-' . $story['id'] . '-' . htmlspecialchars(preg_replace('/[^a-zA-Z\d\àâçéèîïìñôöùûü]+/', '', $_POST['title'])) . $extensionPhoto;

                unlink(PUBLIC_FOLDER . 'upload/story/' . $story['photo']); // ? Suppression de la précédente image
                copy($_FILES['photoCoverUpdate']['tmp_name'], PUBLIC_FOLDER . 'upload/story/' . $photoCoverName); // ? Copie de la nouvelle image dans le dossier concerné
            else :
                $photoCoverName = $_POST['photo'];
            endif;

            if (empty($_POST['title'])) {
                $error['title'] = 'Le champs est obligatoire';
            }

            if (empty($_POST['synopsis'])) {
                $error['synopsis'] = 'Le champs est obligatoire';
            }

            if (empty($_POST['category']) || $_POST['category'] == 'Selectionner') {
                $error['category'] = 'Le champs est obligatoire';
            }

            if (empty($_POST['target_reader']) || $_POST['target_reader'] == 'Selectionner') {
                $error['target_reader'] = 'Le champs est obligatoire';
            }

            if (empty($_POST['language'])) {
                $error['language'] = 'Le champs est obligatoire';
            }

            if (empty($_POST['status'])) {
                $status = 'Brouillon';
            }

            if (empty($_POST['id_user'])) {
                $error['id_user'] = "Le champs est obligatoire et très important, si l'identité de l'utilisateur a été perdu merci d'annuler toute modification et de recommencer ultérieurement.";
            }

            if (empty($error)) :
                Story::update([
                    'id_user' => $_POST['id_user'],
                    'title' => $_POST['title'],
                    'synopsis' => $_POST['synopsis'],
                    'photo' => $photoCoverName,
                    'status' => $_POST['status'],
                    'category' => $_POST['category'],
                    'target_reader' => $_POST['target_reader'],
                    'language' => $_POST['language'],
                    'id' => intval($_POST['id'])
                ]);

                $_SESSION['messages']['success'][] = 'Modification effectuée avec succès !';
                header('location:../story/list');
                exit();

            endif;
        endif;



        include(VIEWS . "app/backoffice/editStory.php");
    }

    // $ CRUD category
    public static function addCategory()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['roles'] != 'ROLE_ADMIN') { // ? Sécurité
            header('location:../../404.php');
            exit();
        }

        $error = [];
        if (!empty($_POST)) {

            if (empty($_POST['title']) || Category::findByTitle(['title' => $_POST['title']])) :
                if (Category::findByTitle(['title' => $_POST['title']])) :
                    $_SESSION['messages']['danger'][] = 'Cette catégorie existe déjà';
                    $error['title'] = '';
                else :
                    $error['title'] = 'Le champs est obligatoire';
                endif;
            endif;

            if (empty($error)) {
                Category::create([
                    'title' => $_POST['title']
                ]);

                $_SESSION['messages']['success'][] = "Création d'une nouvelle catégorie réalisée avec succès !";
                header('location:../category/list');
                exit();
            }
        }


        include(VIEWS . "app/backoffice/addCategory.php");
    }

    public static function editCategory()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['roles'] != 'ROLE_ADMIN') { // ? Sécurité
            header('location:../../404.php');
            exit();
        }

        if (!empty($_GET['id'])) :
            $category = Category::findById(['id' => $_GET['id']]);
        endif;


        $error = [];
        if (!empty($_POST)) {

            if (empty($_POST['title']) || Category::findByTitle(['title' => $_POST['title']])) :
                if (Category::findByTitle(['title' => $_POST['title']])) :
                    $_SESSION['messages']['danger'][] = 'Cette catégorie existe déjà';
                    $error['title'] = '';
                else :
                    $error['title'] = 'Le champs est obligatoire';
                endif;
            endif;

            if (empty($error)) {
                Category::update([
                    'title' => $_POST['title'],
                    'id' => intval($_POST['id'])
                ]);

                $_SESSION['messages']['success'][] = "Modification réalisée avec succès !";
                header('location:../category/list');
                exit();
            }
        }

        include(VIEWS . "app/backoffice/addCategory.php");
    }

    public static function deleteCategory()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['roles'] != 'ROLE_ADMIN') { // ? Sécurité
            header('location:../../404.php');
            exit();
        }

        if (!empty($_GET['id'])) :
            Category::delete([
                'id' => intval($_GET['id'])
            ]);

            $_SESSION['messages']['success'][] = 'Catégorie supprimée avec succès';
        endif;

        header('location:../category/list');
        exit();
    }

    // $ CRUD target_reader
    public static function addTargetReader()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['roles'] != 'ROLE_ADMIN') { // ? Sécurité
            header('location:../../404.php');
            exit();
        }

        $error = [];
        if (!empty($_POST)) {

            if (empty($_POST['title']) || TargetReader::findByTitle(['title' => $_POST['title']]) || preg_match('/[^-+\d]+/g', $_POST['title'])) :
                if (TargetReader::findByTitle(['title' => $_POST['title']])) :
                    $_SESSION['messages']['danger'][] = 'Cette cible existe déjà';
                    $error['title'] = '';
                else :
                    $error['title'] = 'Le champs est obligatoire';
                endif;
            endif;

            if (empty($error)) {

                $title = strval($_POST['title']);

                TargetReader::create([
                    'title' => $title
                ]);

                $_SESSION['messages']['success'][] = "Création d'une nouvelle cible réalisée avec succès !";
                header('location:../target-reader/list');
                exit();
            }
        }

        include(VIEWS . "app/backoffice/addTargetReader.php");
    }

    public static function editTargetReader()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['roles'] != 'ROLE_ADMIN') { // ? Sécurité
            header('location:../../404.php');
            exit();
        }

        if (!empty($_GET['id'])) :
            $targetReader = TargetReader::findById(['id' => $_GET['id']]);
        endif;

        $error = [];
        if (!empty($_POST)) {

            if (empty($_POST['title']) || TargetReader::findByTitle(['title' => $_POST['title']])) :
                if (Category::findByTitle(['title' => $_POST['title']])) :
                    $_SESSION['messages']['danger'][] = 'Cette cible existe déjà';
                    $error['title'] = '';
                else :
                    $error['title'] = 'Le champs est obligatoire';
                endif;
            endif;

            if (empty($error)) {
                TargetReader::update([
                    'title' => $_POST['title'],
                    'id' => intval($_POST['id'])
                ]);

                $_SESSION['messages']['success'][] = "Modification réalisée avec succès !";
                header('location:../target-reader/list');
                exit();
            }
        }

        include(VIEWS . "app/backoffice/addTargetReader.php");
    }

    public static function deleteTargetReader()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['roles'] != 'ROLE_ADMIN') { // ? Sécurité
            header('location:../../404.php');
            exit();
        }

        if (!empty($_GET['id'])) :
            TargetReader::delete([
                'id' => intval($_GET['id'])
            ]);

            $_SESSION['messages']['success'][] = 'Cible supprimée avec succès';
        endif;

        header('location:../target-reader/list');
        exit();
    }

    // $ CRUD report
    public static function editReport()
    {

        if (isset($_POST['fixed'])) {
            // echo '<pre>';
            //     die(var_dump($_SERVER['HTTP_REFERER']));
            // echo '</pre>';
            Report::update([
                'fixed' => 1,
                'id' => $_GET['id']
            ]);
            $_SESSION['messages']['success'][] = 'Signalement résolu !';
            header("location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }

        include(VIEWS . "app/backoffice/listReport.php");
    }
}
