<?php

class Likes extends Db
{

    public static function create(array $data)
    {

        $request = "INSERT INTO likes (id_liker, id_book, id_story, id_chapter, likes, date_created) VALUES (:id_liker, :id_book, :id_story, :id_chapter, :likes, NOW())";
        $response = self::getDb()->prepare($request);
        $response->execute(self::htmlspecialchars($data));

        return self::getDb()->lastInsertId();
    }

    // -                                                                                                                        

    public static function updateBook(array $data)
    {

        $request = "UPDATE likes SET likes = :likes WHERE id_liker = :id_liker AND id_book = :id_book";
        $response = self::getDb()->prepare($request);
        $response->execute(self::htmlspecialchars($data));

        return self::getDb()->lastInsertId();
    }

    public static function updateStory(array $data)
    {

        $request = "UPDATE likes SET likes = :likes WHERE id_liker = :id_liker AND id_story = :id_story";
        $response = self::getDb()->prepare($request);
        $response->execute(self::htmlspecialchars($data));

        return self::getDb()->lastInsertId();
    }

    public static function updateChapter(array $data)
    {

        $request = "UPDATE likes SET likes = :likes WHERE id_liker = :id_liker AND id_chapter = :id_chapter";
        $response = self::getDb()->prepare($request);
        $response->execute(self::htmlspecialchars($data));

        return self::getDb()->lastInsertId();
    }

    // -                                                                                                                        

    public static function findLikeBook(array $data)
    {

        $request = "SELECT * FROM likes WHERE id_liker = :id_liker AND id_book = :id_book";
        $response = self::getDb()->prepare($request);
        $response->execute($data);

        return $response->fetch(PDO::FETCH_ASSOC);
    }

    public static function findLikeStory(array $data)
    {

        $request = "SELECT * FROM likes WHERE id_liker = :id_liker AND id_story = :id_story";
        $response = self::getDb()->prepare($request);
        $response->execute($data);

        return $response->fetch(PDO::FETCH_ASSOC);
    }

    public static function findLikeChapter(array $data)
    {

        $request = "SELECT * FROM likes WHERE id_liker = :id_liker AND id_chapter = :id_chapter";
        $response = self::getDb()->prepare($request);
        $response->execute($data);

        return $response->fetch(PDO::FETCH_ASSOC);
    }

    // -                                                                                                                        

    public static function countLikesBook(array $data)
    {

        $request = "SELECT * FROM likes WHERE id_book = :id_book";
        $response = self::getDb()->prepare($request);
        $response->execute($data);

        return $response->rowCount();
    }

    public static function countLikesStory(array $data)
    {

        $request = "SELECT * FROM likes WHERE id_story = :id_story";
        $response = self::getDb()->prepare($request);
        $response->execute($data);

        return $response->rowCount();
    }

    // -                                                                                                                        


    public static function findByBook(array $data)
    {

        $request = "SELECT * FROM likes INNER JOIN book ON likes.id_book = book.id WHERE likes.id_book = :id_book";
        $response = self::getDb()->prepare($request);
        $response->execute($data);

        return $response->fetchAll(PDO::FETCH_ASSOC);
    }
}
