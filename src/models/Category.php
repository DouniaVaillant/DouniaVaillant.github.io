<?php

class Category extends Db
{

    public static function create(array $data)
    {

        $request = "INSERT INTO category (title) VALUES (:title)";
        $response = self::getDb()->prepare($request);
        $response->execute(self::htmlspecialchars($data));

        return self::getDb()->lastInsertId();
    }

    public static function update(array $data)
    {

        $request = "UPDATE category SET title = :title WHERE id = :id";
        $response = self::getDb()->prepare($request);
        $response->execute(self::htmlspecialchars($data));

        return self::getDb()->lastInsertId();
    }

    public static function findAll()
    {

        $request = "SELECT * FROM category";
        $response = self::getDb()->prepare($request);
        $response->execute();

        return $response->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById(array $id)
    {

        $request = "SELECT * FROM category WHERE id = :id";
        $response = self::getDb()->prepare($request);
        $response->execute($id);

        return $response->fetch(PDO::FETCH_ASSOC);
    }

    public static function findByTitle($title)
    {

        $request = "SELECT * FROM category WHERE title = :title";
        $response = self::getDb()->prepare($request);
        $response->execute($title);

        return $response->fetch(PDO::FETCH_ASSOC);
    }

    public static function delete(array $data)
    {
  
      $request = "DELETE FROM category WHERE id = :id";
  
      $response = self::getDb()->prepare($request);
      return $response->execute(self::htmlspecialchars($data));
    }

}
