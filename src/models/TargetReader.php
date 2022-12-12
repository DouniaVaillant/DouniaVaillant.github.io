<?php

class TargetReader extends Db
{

    public static function create(array $data)
    {

        $request = "INSERT INTO target_reader (title) VALUES (:title)";
        $response = self::getDb()->prepare($request);
        $response->execute(self::htmlspecialchars($data));

        return self::getDb()->lastInsertId();
    }

    public static function update(array $data)
    {

        $request = "UPDATE target_reader SET title = :title WHERE id = :id";
        $response = self::getDb()->prepare($request);
        $response->execute(self::htmlspecialchars($data));

        return self::getDb()->lastInsertId();
    }

    public static function findAll()
    {

        $request = "SELECT * FROM target_reader";
        $response = self::getDb()->prepare($request);
        $response->execute();

        return $response->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById(array $id)
    {

        $request = "SELECT * FROM target_reader WHERE id = :id";
        $response = self::getDb()->prepare($request);
        $response->execute($id);

        return $response->fetch(PDO::FETCH_ASSOC);
    }

    public static function findByTitle($title)
    {

        $request = "SELECT * FROM target_reader WHERE title = :title";
        $response = self::getDb()->prepare($request);
        $response->execute($title);

        return $response->fetch(PDO::FETCH_ASSOC);
    }

    public static function delete(array $data)
    {
  
      $request = "DELETE FROM target_reader WHERE id = :id";
  
      $response = self::getDb()->prepare($request);
      return $response->execute(self::htmlspecialchars($data));
    }

}
