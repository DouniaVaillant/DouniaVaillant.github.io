<?php

class Book extends Db
{

  public static function create(array $data)
  {

    $request = "INSERT INTO book (id_user, category, target_reader, title, author, synopsis, photo, editor, date_publication, status, date_created) VALUES (:id_user, :category, :target_reader, :title, :author, :synopsis, :photo, :editor, :date_publication, :status, NOW())";
    $response = self::getDb()->prepare($request);
    $response->execute(self::htmlspecialchars($data));

    return self::getDb()->lastInsertId();
  }

  public static function update(array $data)
  {

    $request = "UPDATE book SET id_user = :id_user, category = :category, target_reader = :target_reader, title = :title, author = :author, synopsis = :synopsis, photo = :photo, editor = :editor, date_publication = :date_publication, status = :status WHERE id=:id";
    $response = self::getDb()->prepare($request);
    $response->execute(self::htmlspecialchars($data));

    return self::getDb()->lastInsertId();
  }

  public static function findAll()
  {

    $request = "SELECT * FROM book";
    $response = self::getDb()->prepare($request);
    $response->execute();

    return $response->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function findById(array $id)
  {

    $request = "SELECT * FROM book WHERE id = :id";
    $response = self::getDb()->prepare($request);
    $response->execute($id);

    return $response->fetch(PDO::FETCH_ASSOC);
  }

  public static function findByIdUser(array $idUser)
  {

    $request = "SELECT * FROM book WHERE id_user = :id_user";
    $response = self::getDb()->prepare($request);
    $response->execute($idUser);

    return $response->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function findByCategory(array $category)
  {

    $request = "SELECT * FROM book WHERE category = :category";
    $response = self::getDb()->prepare($request);
    $response->execute($category);

    return $response->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function findByStatus(array $status)
  {

    $request = "SELECT * FROM book WHERE status = :status";
    $response = self::getDb()->prepare($request);
    $response->execute($status);

    return $response->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function delete(array $data)
  {

    $request = "DELETE FROM book WHERE id = :id";

    $response = self::getDb()->prepare($request);
    return $response->execute(self::htmlspecialchars($data));
  }
}