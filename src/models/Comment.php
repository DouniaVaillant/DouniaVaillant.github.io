<?php

class Comment extends Db
{

    public static function create(array $data)
    {

        $request = "INSERT INTO comment (id_commentator, id_book, id_story, id_chapter, comment, date_created) VALUES (:id_commentator, :id_book, :id_story, :id_chapter, :comment, NOW())";
        $response = self::getDb()->prepare($request);
        $response->execute(self::htmlspecialchars($data));

        return self::getDb()->lastInsertId();
    }
    
    public static function findAllByBook(array $data)
    {

        $request = "SELECT * FROM comment INNER JOIN book ON comment.id_book = book.id WHERE comment.id_book = :id_book";
        $response = self::getDb()->prepare($request);
        $response->execute($data);

        return $response->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function findAllByStory(array $data)
    {

        $request = "SELECT * FROM comment INNER JOIN story ON comment.id_story = story.id WHERE comment.id_story = :id_story";
        $response = self::getDb()->prepare($request);
        $response->execute($data);

        return $response->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function findAllByChapter(array $data)
    {

        $request = "SELECT * FROM comment INNER JOIN chapter ON comment.id_chapter = chapter.id WHERE comment.id_chapter = :id_chapter";
        $response = self::getDb()->prepare($request);
        $response->execute($data);

        return $response->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function delete(array $data)
    {
  
      $request = "DELETE FROM comment WHERE id = :id";
  
      $response = self::getDb()->prepare($request);
      return $response->execute(self::htmlspecialchars($data));
    }


}