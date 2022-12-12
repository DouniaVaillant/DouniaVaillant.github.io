<?php

class Story extends Db
{

  public static function create(array $data)
  {

    $request = "INSERT INTO story (id_user, title, synopsis, photo, status, category, target_reader, language, date_created) VALUES (:id_user, :title, :synopsis, :photo, :status, :category, :target_reader, :language, NOW())";
    $response = self::getDb()->prepare($request);
    $response->execute(self::htmlspecialchars($data));

    return self::getDb()->lastInsertId();
  }

  public static function update(array $data)
  {

    $request = "UPDATE story SET id_user = :id_user, title = :title, synopsis = :synopsis, photo = :photo, status = :status, category = :category, target_reader = :target_reader, language = :language WHERE id = :id";
    $response = self::getDb()->prepare($request);
    $response->execute(self::htmlspecialchars($data));

    return self::getDb()->lastInsertId();
  }

  public static function findAll()
  {

    $request = "SELECT * FROM story";
    $response = self::getDb()->prepare($request);
    $response->execute();

    return $response->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function findById(array $id)
  {

    $request = "SELECT * FROM story WHERE id = :id";
    $response = self::getDb()->prepare($request);
    $response->execute($id);

    return $response->fetch(PDO::FETCH_ASSOC);
  }

  public static function findByIdUser(array $idUser)
  {

    $request = "SELECT * FROM story WHERE id_user = :id_user";
    $response = self::getDb()->prepare($request);
    $response->execute($idUser);

    return $response->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function findByCategory(array $category)
  {

    $request = "SELECT * FROM story WHERE category = :category";
    $response = self::getDb()->prepare($request);
    $response->execute($category);

    return $response->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function findByStatus(array $status)
  {

    $request = "SELECT * FROM story WHERE status = :status";
    $response = self::getDb()->prepare($request);
    $response->execute($status);

    return $response->fetchAll(PDO::FETCH_ASSOC);
  }

  // -                                                            - //

  public static function discoverNew()
  {

    $request = "SELECT * FROM story ORDER BY date_created DESC LIMIT 7";
    $response = self::getDb()->prepare($request);
    $response->execute();

    return $response->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function delete(array $data)
  {

    $request = "DELETE FROM story WHERE id = :id";

    $response = self::getDb()->prepare($request);
    return $response->execute(self::htmlspecialchars($data));
  }
}
