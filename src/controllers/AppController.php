<?php

class AppController
{

  public static function index()
  {

    // var_dump($_SESSION['user']);

    if (isset($_SESSION['user'])) {
      if (isset($_GET['searchUser'])) :
        $pseudo = htmlspecialchars($_GET['searchUser']);
        $users = User::findByPseudo(
          $pseudo
        );
      endif;
    }

    include(VIEWS . 'app/index.php');
  }

  // $ User Profil
  public static function profile()
  {
    if (!isset($_SESSION['user'])) { // ? Sécurité
      header('location:../');
      exit();
    }

    if (isset($_GET['id'])) :

      $id = $_GET['id'];
      $user = User::findById(['id' => $id]);

      include(VIEWS . "app/user/showProfile.php");

    else :

      $user = User::findById(['id' => $_SESSION['user']['id']]);

      include(VIEWS . "app/user/profile.php");

    endif;
  }

  public static function editProfile()
  {
    if (!isset($_SESSION['user']) || ($_GET['id'] != $_SESSION['user']['id'])) { // ? Sécurité
      header('location:../../404.php');
      exit();
    }

    $user = User::findById(['id' => $_GET['id']]);

    $error = [];
    if (!empty($_POST)) {

      if (!empty($_FILES['photoBannerUpdate']['name']) && $_FILES['photoBannerUpdate']['size'] < 3000000 && ($_FILES['photoBannerUpdate']['type'] == 'image/jpeg' || $_FILES['photoBannerUpdate']['type'] == 'image/png' || $_FILES['photoBannerUpdate']['type'] == 'image/gif')) :

        $extensionBannerUpload = strtolower(strchr($_FILES['photoBannerUpdate']['name'], '.')); /// = srttolower => met en minuscule ||| substr => ignore un élément de la chaîne ||| strrchr => récupère l'extension du fichier
        $photoBannerName = $user['id'] . '-banner-' . date_format(new DateTime(), 'dmHi') . '-' . uniqid() . $extensionBannerUpload;

        // on supprime la précédente photo grace à la méthode unlink qui attend en argument le chemin complet d'acces au fichier à supprimer
        unlink(PUBLIC_FOLDER . 'upload/photos/banner/' . $_POST['photo_banner']);
        // on copie dans notre dossier d'upload le fichier chargé et renommé
        copy($_FILES['photoBannerUpdate']['tmp_name'], PUBLIC_FOLDER . 'upload/photos/banner/' . $photoBannerName);

      else :

        $photoBannerName = $user['photo_banner'];

      endif;

      if (!empty($_FILES['photoProfileUpdate']['name']) && $_FILES['photoProfileUpdate']['size'] < 3000000 && ($_FILES['photoProfileUpdate']['type'] == 'image/jpeg' || $_FILES['photoProfileUpdate']['type'] == 'image/png' || $_FILES['photoProfileUpdate']['type'] == 'image/gif')) :

        $extensionPhotoUpload = strtolower(strchr($_FILES['photoProfileUpdate']['name'], '.')); /// = srttolower => met en minuscule ||| substr => ignore un élément de la chaîne ||| strrchr => récupère l'extension du fichier
        $photoName = $user['id'] . '-profile-' . date_format(new DateTime(), 'dmH') . '-' . uniqid() . $extensionPhotoUpload;

        // on supprime la précédente photo grace à la méthode unlink qui attend en argument le chemin complet d'acces au fichier à supprimer
        unlink(PUBLIC_FOLDER . 'upload/photos/profile/' . $_POST['photo_profile']);
        // on copie dans notre dossier d'upload le fichier chargé et renommé
        copy($_FILES['photoProfileUpdate']['tmp_name'], PUBLIC_FOLDER . 'upload/photos/profile/' . $photoName);

      else :

        $photoName = $user['photo_profile'];

      endif;

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
        // die(var_dump($_FILES['photoProfileUpdate']['name']));
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
          'roles' => $user['roles'],
          'id' => $_SESSION['user']['id']
        ]);

        $sessionUser = User::findById(['id' => $_SESSION['user']['id']]);
        $_SESSION['user'] = $sessionUser;
        $_SESSION['messages']['success'][] = 'Modification effectuée avec succès!';
        header('location:../profile');
        exit();

      endif;
    }


    include(VIEWS . "app/user/editProfile.php");
  }

  public static function editPassword()
  {
    if (!isset($_SESSION['user'])) { // ? Sécurité
      header('location:../');
      exit();
    }

    $error = [];
    if (!empty($_POST)) :

      function valid_pass($candidate)
      {
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

      if (empty($_POST['password']) || !valid_pass($_POST['password'])) :
        $error['password'] = 'Le champs est obligatoire et votre mot de passe doit contenir, majuscule, minuscule, chiffre lettre et caractère spécial';
      endif;
      if (empty($_POST['confirmPassword']) || $_POST['password'] !== $_POST['confirmPassword']) :
        $error['confirmPassword'] = 'Le champs est obligatoire et doit concorder avec le champs mot de passe';
      endif;
      if (empty($_POST['actualMdp']) || !password_verify($_POST['actualMdp'], $_SESSION['user']['password'])) :
        $error['actualMdp'] = 'Le mot de passe actuel est incorrect';
      endif;

      if (empty($error)) :
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        User::editPassword([
          'password' => $password,
          'id' => $_SESSION['user']['id'],
        ]);

        $user = User::findById(['id' => $_SESSION['user']['id']]);
        $_SESSION['user'] = $user;
        $_SESSION['messages']['success'][] = 'Félicitation, mot de passe modifié !';
        header('location:../user/profile');
        exit();

      endif;


    endif;


    include(VIEWS . "app/user/editPassword.php");
  }

  // $ User Book
  public static function showBook()
  {
    //. infos
    $id = $_GET['id'];
    $book = Book::findById(['id' => $id]);
    $comments = Comment::findAllByBook(['id_book' => $book['id']]);
    if (isset($_SESSION['user'])) {
      $likeFound = Likes::findLikeBook([
        'id_liker' => intval($_SESSION['user']['id']),
        'id_book' => intval($_GET['id'])
      ]);
    }
    $countLikes = Likes::countLikesBook(['id_book' => $id]);


    $error = [];
    if (!empty($_POST)) { // ? like ou comment
      if (isset($_SESSION['user'])) {
        if (isset($_POST['comment'])) { // ? comment 

          if (empty($_POST['comment'])) {
            $error['comment'] = 'Commentaire vide';
          }

          if (empty($error)) {
            // die(var_dump($_POST));
            Comment::create([
              'id_commentator' => intval($_SESSION['user']['id']),
              'id_book' => intval($_GET['id']),
              'id_story' => NULL,
              'id_chapter' => NULL,
              'comment' => $_POST['comment']
            ]);
          }
        } elseif (isset($_POST['likes'])) { // ? like
          if ($likeFound) { // ? si existe modifier la valeur de likes
            // die(var_dump($likeFound));
            if ($likeFound['likes'] == 1) {
              Likes::updateBook([
                'likes' => 0,
                'id_liker' => $_SESSION['user']['id'],
                'id_book' => $_GET['id']
              ]);
            } else {
              Likes::updateBook([
                'likes' => 1,
                'id_liker' => $_SESSION['user']['id'],
                'id_book' => $_GET['id']
              ]);
            }
          } else {
            Likes::create([
              'id_liker' => $_SESSION['user']['id'],
              'id_book' => $_GET['id'],
              'id_story' => NULL,
              'id_chapter' => NULL,
              'likes' => 1
            ]);
          }
        }
        header('location:../book/show?id=' . $_GET['id']);
        exit();
      } else {
        $_SESSION['messages']['warning'][] = 'Merci de vous connecter';
        header('location:../user/logIn');
        exit();
      }
    }

    include(VIEWS . "app/book/showBook.php");
  }

  public static function books()
  {

    if (isset($_GET['status'])) :
      if ($_GET['status'] == 'don') {
        $books = Book::findByStatus(['status' => $_GET['status']]);
      } elseif ($_GET['status'] == 'partage') {
        $books = Book::findByStatus(['status' => $_GET['status']]);
      } elseif ($_GET['status'] == 'documentation') {
        $books = Book::findByStatus(['status' => $_GET['status']]);
      } else {
        $_SESSION['message']['danger'][] = 'Statut inconnu ou non renseigné';
        header('location:../404.php');
        exit();
      }
    else :
      $books = Book::findAll();

    endif;


    include(VIEWS . "app/book/books.php");
  }

  public static function userBook()
  {

    $user = $_SESSION['user'];
    $books = Book::findByIdUser(['id_user' => $user['id']]);

    include(VIEWS . "app/book/userBook.php");
  }

  public static function addBook()
  {

    $categories = Category::findAll();
    $targetReader = TargetReader::findAll();
    $user = $_SESSION['user'];

    $error = [];
    if (!empty($_POST)) :

      $category = $_POST['category'];
      $targetReader = $_POST['target_reader'];

      if (!empty($_FILES['photo']['name']) && $_FILES['photo']['size'] < 3000000 && ($_FILES['photo']['type'] == 'image/jpeg' || $_FILES['photo']['type'] == 'image/png' || $_FILES['photo']['type'] == 'image/gif')) :

        $extensionPhoto = strtolower(strchr($_FILES['photo']['name'], '.')); /// = srttolower => met en minuscule ||| substr => ignore un élément de la chaîne ||| strrchr => récupère l'extension du fichier
        $photoCoverName = $user['id'] . '-' . strval(htmlspecialchars(preg_replace('/[^a-zA-Z\d\àâçéèîïìñôöùûü]+/', '', $_POST['title']))) . '-' . strval(uniqid()) . $extensionPhoto;

        copy($_FILES['photo']['tmp_name'], PUBLIC_FOLDER . 'upload/book/' . $photoCoverName); // ? Copie de la nouvelle image dans le dossier concerné

      else :

        $photoCoverName = $_POST['photo'];

      endif;

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
        $error['date_publication'] = 'Veuillez remplir correctement ce champs au format jj/mm/aaaa, aucune lettre n\'est acceptée';
      }

      if (empty($category)) {
        $error['category'] = 'Le champs est obligatoire';
      }

      if (empty($targetReader)) {
        $error['target_reader'] = 'Le champs est obligatoire';
      }

      if (empty($_POST['status'])) {
        $error['status'] = 'Le champs est obligatoire';
      }


      if (empty($error)) :
        Book::create([
          'id_user' => $user['id'],
          'category' => $_POST['category'],
          'target_reader' => $_POST['target_reader'],
          'title' => $_POST['title'],
          'author' => $_POST['author'],
          'synopsis' => $_POST['synopsis'],
          'photo' => $photoCoverName,
          'editor' => $_POST['editor'],
          'date_publication' => $_POST['date_publication'],
          'status' => $_POST['status']
        ]);

        $_SESSION['messages']['success'][] = 'Publication effectuée avec succès !';
        header('location:../');
        exit();

      endif;

    endif;

    include(VIEWS . "app/book/addBook.php");
  }

  public static function editUserBook()
  {

    if (!empty($_GET['id'])) {
      $book = Book::findById(['id' => $_GET['id']]);
    }

    $categories = Category::findAll();
    $targetReader = TargetReader::findAll();
    $user = $_SESSION['user'];

    $error = [];
    if (!empty($_POST)) :
      // die(var_dump($book));

      $category = $_POST['category'];
      $editor = $_POST['editor'];

      // * Couverture
      if (!empty($_FILES['photoCoverUpdate']['name']) && $_FILES['photoCoverUpdate']['size'] < 3000000 && ($_FILES['photoCoverUpdate']['type'] == 'image/jpeg' || $_FILES['photoCoverUpdate']['type'] == 'image/png' || $_FILES['photoCoverUpdate']['type'] == 'image/gif')) :
        $extensionPhoto = strtolower(strchr($_FILES['photoCoverUpdate']['name'], '.')); /// = srttolower => met en minuscule ||| substr => ignore un élément de la chaîne ||| strrchr => récupère l'extension du fichier
        $photoCoverName = $user['id'] . '-' . $book['id'] . '-' . htmlspecialchars(preg_replace('/[^a-zA-Z\d\àâçéèîïìñôöùûü]+/', '', $_POST['title'])) . $extensionPhoto;

        unlink(PUBLIC_FOLDER . 'upload/book/' . $book['photo']); // ? Suppression de la précédente image
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
        Book::update([
          'id_user' => $user['id'],
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
        header('location:../books');
        exit();

      endif;

    endif;

    include(VIEWS . "app/book/addBook.php");
  }

  public static function deleteBook()
  {

    if (!isset($_SESSION['user'])) {  // ? Sécurité
      header('location:../');
      exit();
    }

    if (!empty($_GET['id'])) :
      $book = Book::findById(['id' => $_GET['id']]);
      unlink(PUBLIC_FOLDER . 'upload/book/' . $book['photo']); // ? Suppression de la photo de couverture du livre à supprimer
      Book::delete([
        'id' => intval($_GET['id'])
      ]);

      $_SESSION['messages']['success'][] = 'Livre supprimé avec succès';
    endif;

    header('location:../book/list');
    exit();
    include(VIEWS . "app/book/deleteBook.php");
  }

  // $ User Story
  public static function showStory()
  {

    $id = $_GET['id'];
    $story = Story::findById(['id' => $id]);
    $chapters = Chapter::findByStory(['id_story' => intval($_GET['id'])]);
    $comments = Comment::findAllByStory(['id_story' => $story['id']]);
    if (isset($_SESSION['user'])) {
      $likeFound = Likes::findLikeStory([
        'id_liker' => intval($_SESSION['user']['id']),
        'id_story' => intval($_GET['id'])
      ]);
    }
    $countLikes = Likes::countLikesStory(['id_story' => $id]);
    $discoverStories = Story::discoverNew();

    $error = [];
    if (!empty($_POST)) { // ? like ou comment
      if (isset($_SESSION['user'])) {
        if (isset($_POST['comment'])) { // ? comment 

          if (empty($_POST['comment'])) {
            $error['comment'] = 'Commentaire vide';
          }

          if (empty($error)) {
            // die(var_dump($_POST));
            Comment::create([
              'id_commentator' => intval($_SESSION['user']['id']),
              'id_book' => NULL,
              'id_story' => intval($_GET['id']),
              'id_chapter' => NULL,
              'comment' => $_POST['comment']
            ]);
          }
        } elseif (isset($_POST['likes'])) { // ? like
          if ($likeFound) { // ? si existe modifier la valeur de likes
            // die(var_dump($likeFound));
            if ($likeFound['likes'] == 1) {
              Likes::updateStory([
                'likes' => 0,
                'id_liker' => $_SESSION['user']['id'],
                'id_story' => $_GET['id']
              ]);
            } else {
              Likes::updateStory([
                'likes' => 1,
                'id_liker' => $_SESSION['user']['id'],
                'id_story' => $_GET['id']
              ]);
            }
          } else {
            Likes::create([
              'id_liker' => $_SESSION['user']['id'],
              'id_book' => NULL,
              'id_story' => $_GET['id'],
              'id_chapter' => NULL,
              'likes' => 1
            ]);
          }
        }
        header('location:../story/show?id=' . $_GET['id']);
        exit();
      } else {
        $_SESSION['messages']['warning'][] = 'Merci de vous connecter';
        header('location:../user/logIn');
        exit();
      }
    }

    include(VIEWS . "app/story/showStory.php");
  }

  public static function stories()
  {

    $stories = Story::findAll();
    // ! $inLibrary 
    if (isset($_SESSION['user'])) {
      $inLibrary = Library::findAll([
        'id_user' => $_SESSION['user']['id']
      ]);
    }

    include(VIEWS . "app/story/stories.php");
  }

  public static function userStory()
  {

    $user = $_SESSION['user'];
    $stories = Story::findByIdUser(['id_user' => $user['id']]);

    include(VIEWS . "app/story/userStory.php");
  }

  public static function addStory()
  {
    $user = $_SESSION['user'];

    if (!isset($user)) {
      $_SESSION['messages']['danger'][] = "Impossible d'accéder à cette requête";
      header('location:../');
      exit();
    }

    $categories = Category::findAll();
    $targetReader = TargetReader::findAll();

    $error = [];
    if (!empty($_POST)) :

      $category = $_POST['category'];
      $targetReader = $_POST['target_reader'];

      if (!empty($_FILES['photo']['name']) && $_FILES['photo']['size'] < 3000000 && ($_FILES['photo']['type'] == 'image/jpeg' || $_FILES['photo']['type'] == 'image/png' || $_FILES['photo']['type'] == 'image/gif')) :

        $extensionPhoto = strtolower(strchr($_FILES['photo']['name'], '.')); /// = srttolower => met en minuscule ||| substr => ignore un élément de la chaîne ||| strrchr => récupère l'extension du fichier
        $photoCoverName = $user['id'] . '-' . strval(htmlspecialchars(preg_replace('/[^a-zA-Z\d\àâçéèîïìñôöùûü]+/', '', $_POST['title']))) . '-' . strval(uniqid()) . $extensionPhoto;

        copy($_FILES['photo']['tmp_name'], PUBLIC_FOLDER . 'upload/story/' . $photoCoverName); // ? Copie de la nouvelle image dans le dossier concerné

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

      if (empty($error)) :
        Story::create([
          'id_user' => $user['id'],
          'title' => $_POST['title'],
          'synopsis' => $_POST['synopsis'],
          'photo' => $photoCoverName,
          'status' => $status,
          'category' => $_POST['category'],
          'target_reader' => $_POST['target_reader'],
          'language' => $_POST['language']
        ]);

        $_SESSION['messages']['success'][] = 'Publication effectuée avec succès !';
        header('location:../user/stories');
        exit();

      endif;
    endif;

    include(VIEWS . "app/story/addStory.php");
  }

  public static function editUserStories()
  {

    $user = $_SESSION['user'];

    if (!isset($user)) {
      $_SESSION['messages']['danger'][] = "Impossible d'accéder à cette requête";
      header('location:../../');
      exit();
    }

    if (!empty($_GET['id'])) {
      $story = Story::findById(['id' => $_GET['id']]);
    }

    $categories = Category::findAll();
    $targetReader = TargetReader::findAll();

    $error = [];
    if (!empty($_POST)) :

      if (!empty($_FILES['photoCoverUpdate']['name']) && $_FILES['photoCoverUpdate']['size'] < 3000000 && ($_FILES['photoCoverUpdate']['type'] == 'image/jpeg' || $_FILES['photoCoverUpdate']['type'] == 'image/png' || $_FILES['photoCoverUpdate']['type'] == 'image/gif')) :
        $extensionPhoto = strtolower(strchr($_FILES['photoCoverUpdate']['name'], '.')); /// = srttolower => met en minuscule ||| substr => ignore un élément de la chaîne ||| strrchr => récupère l'extension du fichier
        $photoCoverName = $user['id'] . '-' . $story['id'] . '-' . htmlspecialchars(preg_replace('/[^a-zA-Z\d\àâçéèîïìñôöùûü]+/', '', $_POST['title'])) . $extensionPhoto;

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

      if (empty($error)) :
        Story::update([
          'id_user' => $_SESSION['user']['id'],
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
        header('location:../stories');
        exit();

      endif;
    endif;


    include(VIEWS . "app/story/addStory.php");
  }

  public static function deleteStory()
  {
    if (!isset($_SESSION['user'])) {  // ? Sécurité
      header('location:../');
      exit();
    }

    if (!empty($_GET['id'])) :
      $story = Story::findById(['id' => $_GET['id']]);
      unlink(PUBLIC_FOLDER . 'upload/story/' . $story['photo']); // ? Suppression de la photo de couverture du livre à supprimer
      Story::delete([
        'id' => intval($_GET['id'])
      ]);

      $_SESSION['messages']['success'][] = 'Histoire supprimée avec succès';
    endif;

    header('location:../story/list');
    exit();
    include(VIEWS . "app/story/deleteStory.php");
  }

  public static function addChapter()
  {

    // die(var_dump($_POST['story']));
    $story = Story::findById(['id' => intval($_POST['id_story'])]);

    $error = [];
    if (!empty($_POST)) {
      $title = $_POST['title'];
      $content = $_POST['content'];
      $chapterNumber = $_POST['chapter_number'];

      if (empty($_POST['title'])) {
        $title = 'Chapitre';
      }

      if (empty($_POST['content'])) {
        $content = 'Vide';
      }

      if (empty($_POST['chapter_number']) || preg_match('/[^1-9]+/', $_POST['chapter_number'])) {
        $error = 'Merci de renseigner ce champs correctement (seuls sont acceptés les chiffres allant de 1 à 9 sans espace).';
      }

      if (empty($error)) {
        Chapter::create([
          'id_story' => intval($story['id']),
          'title' => $title,
          'content' => $content,
          'chapter_number' => $chapterNumber
        ]);

        $_SESSION['messages']['success'][] = "Création d'un nouveau chapitre réalisée avec succès !";
        header('location:../show?id=' . $story['id']);
        exit();
      }
    }


    include(VIEWS . "app/story/chapter/addChapter.php");
  }

  public static function showChapter()
  {
    if (!isset($_SESSION['user'])) {  // ? Sécurité
      $_SESSION['messages']['warning'][] = 'Merci de vous connecter pour accéder à ce contenu.';
      header('location:../../');
      exit();
    }

    $chapter = Chapter::findById(['id' => $_GET['id']]);
    // die(var_dump($chapter));

    $comments = Comment::findAllByChapter(['id_chapter' => $chapter['id']]);
    $likeFound = Likes::findLikeChapter([
      'id_liker' => intval($_SESSION['user']['id']),
      'id_chapter' => intval($_GET['id'])
    ]);

    $error = [];
    if (!empty($_POST)) { // ? like ou comment
      if (isset($_SESSION['user'])) {
        if (isset($_POST['comment'])) { // ? comment 

          if (empty($_POST['comment'])) {
            $error['comment'] = 'Commentaire vide';
          }

          if (empty($error)) {
            // die(var_dump($_POST));
            Comment::create([
              'id_commentator' => intval($_SESSION['user']['id']),
              'id_book' => NULL,
              'id_story' => NULL,
              'id_chapter' => intval($_GET['id']),
              'comment' => $_POST['comment']
            ]);
          }
        } elseif (isset($_POST['likes'])) { // ? like
          if ($likeFound) { // ? si existe modifier la valeur de likes
            // die(var_dump($likeFound));
            if ($likeFound['likes'] == 1) {
              Likes::updateChapter([
                'likes' => 0,
                'id_liker' => $_SESSION['user']['id'],
                'id_chapter' => $_GET['id']
              ]);
            } else {
              Likes::updateChapter([
                'likes' => 1,
                'id_liker' => $_SESSION['user']['id'],
                'id_chapter' => $_GET['id']
              ]);
            }
          } else {
            Likes::create([
              'id_liker' => $_SESSION['user']['id'],
              'id_book' => NULL,
              'id_story' => NULL,
              'id_chapter' => $_GET['id'],
              'likes' => 1
            ]);
          }
        }
        header('location:../chapter/show?id=' . $_GET['id']);
        exit();
      } else {
        $_SESSION['messages']['warning'][] = 'Merci de vous connecter';
        header('location:../user/logIn');
        exit();
      }
    }

    include(VIEWS . "app/story/chapter/showChapter.php");
  }

  public static function library()
  {

    if (isset($_GET['id'])) :
      if (Library::findByIdStoryAndUser([
        'id_story' => $_GET['id'],
        'id_user' => $_SESSION['user']['id']
      ])) {
        Library::delete([
          'id_user' => $_SESSION['user']['id'],
          'id_story' => $_GET['id']
        ]);
      } else {

        Library::create([
          'id_user' => $_SESSION['user']['id'],
          'id_story' => $_GET['id']
        ]);
      }

      header('location:stories');
      exit();

    else :

      $user = $_SESSION['user'];
      $library = Library::findAll(['id_user' => $user['id']]);

    endif;


    include(VIEWS . "app/story/library/library.php");
  }

  public static function report()
  {

    // $backToUrl = $_SERVER['HTTP_REFERER'];

    // var_dump($_POST);
    $error = [];
    if (!empty($_POST)) {
      if (isset($_GET['u-reported']) && isset($_GET['u-reporter'])) {

        if (empty($_POST['reason'])) {
          $error['reason'] = 'Ce champs est obligatoire';
        }

        if (empty($error)) {
          Report::create([
            'id_reporter' => $_GET['u-reporter'],
            'id_reported' => $_GET['u-reported'],
            'id_book' => NULL,
            'id_story' => NULL,
            'id_chapter' => NULL,
            'reason' => $_POST['reason']
          ]);

          $_SESSION['messages']['success'][] = 'Utilisateur signalé !';
          header('location:user/profile?id=' . $_GET['u-reported']);
          exit();
        }
      }

      if (isset($_GET['s-reported']) && isset($_GET['u-reporter'])) {
        if (empty($_POST['reason'])) {
          $error['reason'] = 'Merci de choisir qu\'elle situation correspond le mieux ou de quitter cette page si le signalement était une erreur.';
        }

        if (empty($error)) {
          Report::create([
            'id_reporter' => $_GET['u-reporter'],
            'id_reported' => NULL,
            'id_book' => NULL,
            'id_story' => $_GET['s-reported'],
            'id_chapter' => NULL,
            'reason' => $_POST['reason']
          ]);

          $_SESSION['messages']['success'][] = 'Signalement effectué !';
          header('location:stories');
          exit();
        }
      }

      if (isset($_GET['c-reported']) && isset($_GET['u-reporter'])) {
        $story = Story::findById(['id' => $_GET['c-reported']]);

        if (empty($_POST['reason'])) {
          $error['reason'] = 'Merci de choisir qu\'elle situation correspond le mieux ou de quitter cette page si le signalement était une erreur.';
        }

        if (empty($error)) {

          Report::create([
            'id_reporter' => $_GET['u-reporter'],
            'id_reported' => NULL,
            'id_book' => NULL,
            'id_story' => NULL,
            'id_chapter' => $_GET['c-reported'],
            'reason' => $_POST['reason']
          ]);

          $_SESSION['messages']['success'][] = 'Signalement effectué !';
          header('location:story/show?id=' . $story['id']);
          exit();
        }
      }

      if (isset($_GET['b-reported']) && isset($_GET['u-reporter'])) {

        if (empty($_POST['reason'])) {
          $error['reason'] = 'Merci de choisir qu\'elle situation correspond le mieux ou de quitter cette page si le signalement était une erreur.';
        }

        if (empty($error)) {

          Report::create([
            'id_reporter' => $_GET['u-reporter'],
            'id_reported' => NULL,
            'id_book' => $_GET['b-reported'],
            'id_story' => NULL,
            'id_chapter' => NULL,
            'reason' => $_POST['reason']
          ]);

          $_SESSION['messages']['success'][] = 'Signalement effectué !';
          header('location:book/show?id=' . $_GET['b-reported']);
          // header('location: '. $backToUrl. '');
          exit();
        }
      }
    }


    include(VIEWS . "app/report.php");
  }
}
