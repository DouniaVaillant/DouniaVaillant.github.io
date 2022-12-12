<?php 

class Report extends Db {


    public static function create(array $data)
    {

        $request = "INSERT INTO report (id_reporter, id_reported, id_book, id_story, id_chapter, reason, fixed, date_created) VALUES (:id_reporter, :id_reported, :id_book, :id_story, :id_chapter, :reason, 0, NOW())";
        $response = self::getDb()->prepare($request);
        $response->execute(self::htmlspecialchars($data));

        return self::getDb()->lastInsertId();
    }

    public static function update(array $data)
    {
  
      $request = "UPDATE report SET fixed = :fixed WHERE id=:id";
      $response = self::getDb()->prepare($request);
      $response->execute(self::htmlspecialchars($data));
  
      return self::getDb()->lastInsertId();
    }

    public static function findAllDesc()
    {
  
      $request = "SELECT * FROM report ORDER BY date_created DESC";
      $response = self::getDb()->prepare($request);
      $response->execute();
  
      return $response->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findUserFixed()
    {
  
      $request = "SELECT * FROM report WHERE fixed = 1 AND id_reported != 0 ORDER BY date_created DESC";
      $response = self::getDb()->prepare($request);
      $response->execute();
  
      return $response->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findUser()
    {
  
      $request = "SELECT * FROM report WHERE id_reported != 0 ORDER BY date_created DESC";
      $response = self::getDb()->prepare($request);
      $response->execute();
  
      return $response->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findBook()
    {
  
      $request = "SELECT * FROM report WHERE id_book != 0 ORDER BY date_created DESC";
      $response = self::getDb()->prepare($request);
      $response->execute();
  
      return $response->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findStory()
    {
  
      $request = "SELECT * FROM report WHERE id_story != 0 ORDER BY date_created DESC";
      $response = self::getDb()->prepare($request);
      $response->execute();
  
      return $response->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findChapter()
    {
  
      $request = "SELECT * FROM report WHERE id_chapter != 0 ORDER BY date_created DESC";
      $response = self::getDb()->prepare($request);
      $response->execute();
  
      return $response->fetchAll(PDO::FETCH_ASSOC);
    }

























}