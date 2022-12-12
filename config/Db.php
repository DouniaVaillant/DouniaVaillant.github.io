<?php

class Db {

    protected static function getDb() {
        try {
            $bdd = new PDO('mysql:host=' . CONFIG['db']['DB_HOST'] . ';dbname=' . CONFIG['db']['DB_NAME'] . ';charset=utf8;port=' . CONFIG['db']['DB_PORT'],
                            CONFIG['db']['DB_USER'],
                            CONFIG['db']['DB_PSWD'],
                            [
                                'ATTR_ERRMODE' => PDO::ERRMODE_EXCEPTION,
            ]);
            return $bdd;
        } catch (Exception $e) {
            var_dump($e);
            die;
        }
    }

    protected static function htmlspecialchars($data)
    {

        foreach ($data as $marqueur=>$valeur){

            $data[$marqueur]=htmlspecialchars($valeur);
            // on transforme les chevrons en entité html qui neutralise les balises script ou style eventuellement injectées
            // On parle de neutraliser les failles xss et css

        }

        return $data;


    }
}