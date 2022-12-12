<?php 

class Library extends Db {

    public static function create(array $data)
    {

        $request = "INSERT INTO library (id_user, id_story) VALUES (:id_user, :id_story)";
        $response = self::getDb()->prepare($request);
        $response->execute(self::htmlspecialchars($data));

        return self::getDb()->lastInsertId();
    }

    public static function findAll(array $data)
    {

        $request = "SELECT * FROM library INNER JOIN story ON library.id_story = story.id WHERE library.id_user = :id_user";
        $response = self::getDb()->prepare($request);
        $response->execute($data);

        return $response->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function findByIdStoryAndUser(array $id)
    {

        $request = "SELECT * FROM library WHERE id_story = :id_story AND id_user = :id_user";
        $response = self::getDb()->prepare($request);
        $response->execute($id);

        return $response->fetch(PDO::FETCH_ASSOC);
    }

    public static function delete(array $data)
    {
  
      $request = "DELETE FROM library WHERE id_user = :id_user AND id_story = :id_story";
  
      $response = self::getDb()->prepare($request);
      return $response->execute(self::htmlspecialchars($data));
    }










}