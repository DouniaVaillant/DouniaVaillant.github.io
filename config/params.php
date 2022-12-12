<?php

/**
 * Fichier contenant la configuration de l'application
 */
const CONFIG = [
    'db' => [
        'DB_HOST' => 'localhost',
        'DB_PORT' => '3306',
        'DB_NAME' => 'liedon',
        'DB_USER' => 'root',
        'DB_PSWD' => '',
    ],
    'app' => [
        'name' => 'LIEDON',
        'projectBaseUrl' => 'http://localhost/LIEDON'
    ]
];

/**
 * Constantes pour accéder rapidement aux dossiers importants du MVC
 */
const BASE_DIR = __DIR__ . '\\..\\';
const BASE = CONFIG['app']['projectBaseUrl'] . '/public/';
const BASE_PATH = CONFIG['app']['projectBaseUrl'] . '/public/index.php/';
const PUBLIC_FOLDER = BASE_DIR . 'public\\';
const VIEWS = BASE_DIR . 'views/';
const MODELS = BASE_DIR . 'src/models/';
const CONTROLLERS = BASE_DIR . 'src/controllers/';


/**
 * Liste des actions/méthodes possibles (les routes du routeur)
 */
$routes = [
    ''                              => ['AppController', 'index'],
    '/'                             => ['AppController', 'index'],
    '/user/registration'            => ['RegistrationController', 'registration'],
    '/user/logIn'                   => ['RegistrationController', 'logIn'],
    '/user/logOut'                  => ['RegistrationController', 'logOut'],

    '/admin/backoffice'             => ['AdminController', 'index'],
    '/admin/user/list'              => ['AdminController', 'listUser'],
    '/admin/user/add'               => ['AdminController', 'addUser'],
    '/admin/user/edit'              => ['AdminController', 'editUser'],
    '/admin/user/delete'            => ['AdminController', 'deleteUser'],
    '/admin/category/list'          => ['AdminController', 'listCategory'],
    '/admin/category/add'           => ['AdminController', 'addCategory'],
    '/admin/category/edit'          => ['AdminController', 'editCategory'],
    '/admin/category/delete'        => ['AdminController', 'deleteCategory'],
    '/admin/target-reader/list'     => ['AdminController', 'listTargetReader'],
    '/admin/target-reader/add'      => ['AdminController', 'addTargetReader'],
    '/admin/target-reader/edit'     => ['AdminController', 'editTargetReader'],
    '/admin/target-reader/delete'   => ['AdminController', 'deleteTargetReader'],
    '/admin/book/list'              => ['AdminController', 'listBook'],
    '/admin/book/add'               => ['AdminController', 'addBook'],
    '/admin/book/edit'              => ['AdminController', 'editBook'],
    '/admin/story/list'             => ['AdminController', 'listStory'],
    '/admin/story/edit'             => ['AdminController', 'editStory'],
    '/admin/report/list'            => ['AdminController', 'listReport'],
    '/admin/report/edit'            => ['AdminController', 'editReport'],
    
    '/user/profile'                 => ['AppController', 'profile'],
    '/user/profile/edit'            => ['AppController', 'editProfile'],
    '/user/editPassword'            => ['AppController', 'editPassword'],
    
    '/books'                        => ['AppController', 'books'],
    '/user/books'                   => ['AppController', 'userBook'],
    '/book/show'                    => ['AppController', 'showBook'],
    '/book/add'                     => ['AppController', 'addBook'],
    '/user/books/edit'              => ['AppController', 'editUserBook'],
    '/book/delete'                  => ['AppController', 'deleteBook'],
    
    '/stories'                      => ['AppController', 'stories'],
    '/user/stories'                 => ['AppController', 'userStory'],
    '/story/show'                   => ['AppController', 'showStory'],
    '/story/add'                    => ['AppController', 'addStory'],
    '/user/stories/edit'            => ['AppController', 'editUserStories'],
    '/story/delete'                 => ['AppController', 'deleteStory'],
    '/library'                      => ['AppController', 'library'],
    '/story/chapter/add'            => ['AppController', 'addChapter'],
    '/story/chapter/show'           => ['AppController', 'showChapter'],

    '/report'                        => ['AppController', 'report'],

];
