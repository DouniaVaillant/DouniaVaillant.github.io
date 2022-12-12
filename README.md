# Bibliotheque

Projet pour jury de formation Doranco dev web Fullstack.
Il y a deux principales fonctionnalités:

- "histoire" = les histoires/nouvelles créées par les utilisateurs
- "livre papier" = numérisation de la couverture des livres papiers lus par les utilisateurs avec leur commentaire sur ce livre et une potentielle proposition au partage/don

## Fonctionnalités

##### DE BASE:

- [x] Inscription/connexion/deconnexion
- [ ] Barre de recherche
- [ ] Changer la langue du site (français, anglais)
- [ ] Contacter les gérants du site

##### SUR SON PROFIL:

- [x] Accéder à/modifier ses informations
- [ ] Ajouter des liens vers ses réseaux sociaux
- [ ] Accéder à/modifier ses abonnements
- [ ] Possibilité de publier des posts sur son profile
- [x] Ajouter un livre papier
- [ ] Mettre au partage/don de livre papier
- [ ] Partager son emplacement géographique (adresse)

##### Paramètres:

- [ ] Possibilité de rendre publique ou privés sa bibliothèque et certaines de ses informations
- [ ] Supprimer définitivement son compte
- [x] Pouvoir masquer la partie histoire ou livres papier (c-à-d ne voir que les histoires créées par les utilisateurs ou que les livres papiers partagés)

##### PRINCIPALES:

##### V1:

- [x] Possibilité de publication/modif/supp d'histoires/de nouvelles créées par soi-même (l'ecriture de l'histoire sur le site)
- [ ] Abonnement/désabonnement à des profiles
- [ ] Filtre (dans la page de flux) des histoires en fonction de leur catégorie (+ possibilié de cacher des histoires avec des mots clés)
- [ ] Affichage du contenu adapté à l'âge de l'utilisateur
- [ ] Newsletter des histoires/nouvelles crées (les mieux votés sont proposés à certains utilisateurs aléatoirement)

##### V2:

- [x] Partager un aperçu de livres (papier) lus avec des commentaires sur ces livres
- [ ] Pouvoir indiquer aux autres utilisateurs que nous proposons au partage/don nos livres ( john propose _Le petit prince_ au partage )
- [x] Voir la disponibilité des livres
- [ ] Date limite pour rendre les livres empruntés
- [ ] Avoir un lien redirigeant les utilisateurs intéressés par un livre papier partagé par un utilisateur vers un site qui vendrait ce livre (ex: fnac ...)

##### BIBLIOTHEQUE:

- [x] Ajouter/retirer une histoire de la bibliothèque
- [x] Possibilité de lire les histoires publiées par les autres utilisateurs
- [x] Possibilité de commenter et de mettre un j'aime sur l'histoire

<!--
## Pages

- [x] Inscription/connexion
- [ ] Accueil
- [ ] Son Profile
- [ ] (Consulter le) Profile d'un utilisateur
- [ ] Page de flux d'histoires d'autres utilisateurs (triés par date de création décroissante**)
- [ ] Page de flux de livres papier
- [ ] Aperçu d'une histoire (photo, synopsis, mots clés, ...)

- [ ] Créer la couverture de l'histoire (photo, titre, synopsis, catégories, mots clés, lectorat visé, langue (fr ou en), droits d'auteur, contenu choquant ou non)
- [ ] Ecrire l'histoire (nom du chapitre puis textarea, bouton d'enregistrement/suppression

- [ ] Créer la description d'un livre papier

- [ ] Gérer mes histoires
- [ ] Gérer mes livres papiers proposés au partage / et non proposé au partage (pages diff)

(footer)
- [ ] Mentions légales : Politique de confidentialité, conditions générales d'utilisation, directives relatives au contenu, rgpd
- [ ] A propos
- [ ] Equipe
- [ ] Gestion des préférences concernant les cookies

** plus tard trier en fonction des goûts de l'utilisateur
-->

## BDD

<img width="461" alt="image" src="https://user-images.githubusercontent.com/100844563/199120183-0b0e84e0-51e0-492b-badf-dcba3a138182.png">

Utilisateur

- roles
- nom
- prenom
- email
- mdp
- voie
- rue
- ville
- code_postale
- date_naissance
- photo_profile
- photo_bannière
- date_inscription

Histoire

- id_utilisateur (auteur)
- titre
- synopsis
- photo
- catégorie (choice)
- mots clés
- lectorat visé (choice)
- langue (fr ou en) (choice)
- droits d'auteur (choice)
- contenu mature (oui ou non) (choice)
- statut
- date_creation

Chapitre

- id_histoire
- ordre (num du chapitre)
- titre
- contenu
- date_creation
- date_modification

Bibliothèque

- id_utilisateur
- id_histoire

Avis

- id_utilisateur (commentateur)
- id_histoire
- commentaire (null)
- j'aime (bool) (null)
- date_publication

Livre_papier

- id_utilisateur
- titre
- auteur
- synopsis
- date_publication
- editeur
- categorie
- mot_cle
- photo
- statut

Emprunt

- id_utilisateur (preteur)
- id_utilisateur (emprunteur)
- id_livre_papier
- date_emprunt
- date_rendu

<img width="429" alt="image" src="https://user-images.githubusercontent.com/100844563/199812045-5c571f8a-a271-4c07-8b98-92a8c953dd5a.png">

<!-- !   form comment
!        comments
!        j'aime
!  -->

<!-- !
<?php foreach ($comments as $comment) : ?>
    <?php $otherCommentUser = User::findById(['id' => $comment['id_commentator']]); ?>
    <img class="roundProfile" src="<?= BASE . 'upload/photos/profile/' . $otherCommentUser['photo_profile']; ?>" alt="Photo de profil <?= $otherCommentUser['pseudo']; ?>">
    <?= $otherCommentUser['pseudo']; ?>
    <p><?= $comment['comment']; ?></p>
<?php endforeach; ?>

<form action="<?= BASE_PATH . 'story/show?id=' . $story['id']; ?>" method="post">
    <label for="comment" class="form-label">Vous avez lu et voulez partager votre avis sur cette histoire ?</label>
    <textarea name="comment" class="form-control" id="comment" rows="3" style="resize: none;"></textarea>
    <small><?= $error['comment'] ?? ""; ?></small>
    <button class="btn bg-lightGreen darkGreen" type="submit">Envoyer</button>
</form>

<form action="<?= BASE_PATH . 'story/show?id=' . $story['id']; ?>" method="post">
    <button type="submit" class="btn" name="likes">
        <?php if ($likeFound && ($likeFound['likes'] == 1)) : ?>
            <i class="fa-solid fa-heart text-danger"></i>
        <?php else : ?>
            <i class="fa-regular fa-heart text-danger"></i>
        <?php endif; ?>
    </button>
</form>

! -->
