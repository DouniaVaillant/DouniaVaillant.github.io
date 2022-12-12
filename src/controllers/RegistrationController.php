<?php 


class RegistrationController {
    
  // $ User Log
  public static function registration()
  {

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

      if (empty($_POST['pseudo'])) {
        $error['pseudo'] = 'Le champs est obligatoire';
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
          'roles' => 'ROLE_USER',
          'lastname' => $_POST['lastname'],
          'firstname' => $_POST['firstname'],
          'pseudo' => $_POST['pseudo'],
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

        $_SESSION['messages']['success'][] = 'Félicitation, vous êtes à présent inscrit. Connectez-vous !';
        header('location:../user/logIn');
        exit();
      endif;
    }


    include(VIEWS . "app/user/registration.php");
  }

  public static function logIn()
  {

    if (!empty($_POST)) :
      $user = User::findByEmail(['email' => $_POST['email']]);
      // var_dump($_POST['password'], $user['password']);

      if ($user) :
        if (password_verify($_POST['password'], $user['password'])) :
          $_SESSION['user'] = $user;
          $_SESSION['messages']['success'][] = "Bienvenue " . $user['pseudo'] . " !";
          header('location:../');
          exit();
        else :
          $_SESSION['messages']['danger'][] = 'Erreur sur le mot de passe';
        endif;


      else :
        $_SESSION['messages']['danger'][] = 'Aucun compte existant à cette adresse mail';
      endif;


    endif;


    include(VIEWS . "app/user/logIn.php");
  }

  public static function logOut()
  {
    unset($_SESSION['user']);
    $_SESSION['messages']['info'][] = 'A bientôt !';
    header('location:../');
    exit();
  }
  
}