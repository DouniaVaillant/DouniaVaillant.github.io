<?php

class Chapter extends Db
{


    public static function create(array $data)
    {

        $request = "INSERT INTO chapter (id_story, chapter_number, title, content, date_created) VALUES (:id_story, :chapter_number, :title, :content, NOW())";
        $response = self::getDb()->prepare($request);
        $response->execute(self::htmlspecialchars($data));

        return self::getDb()->lastInsertId();
    }

    public static function update(array $data)
    {

        $request = "UPDATE chapter SET title = :title WHERE id = :id";
        $response = self::getDb()->prepare($request);
        $response->execute(self::htmlspecialchars($data));

        return self::getDb()->lastInsertId();
    }

    public static function findAll()
    {

        $request = "SELECT * FROM chapter";
        $response = self::getDb()->prepare($request);
        $response->execute();

        return $response->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById(array $id)
    {

        $request = "SELECT * FROM chapter WHERE id = :id";
        $response = self::getDb()->prepare($request);
        $response->execute($id);

        return $response->fetch(PDO::FETCH_ASSOC);
    }

    public static function findByStory(array $data)
    {

        $request = "SELECT * FROM chapter WHERE id_story = :id_story";
        $response = self::getDb()->prepare($request);
        $response->execute($data);

        return $response->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function readFirstChapter(array $data)
    {

        $request = "SELECT * FROM chapter WHERE id_story = :id_story ORDER BY date_created ASC LIMIT 1";
        $response = self::getDb()->prepare($request);
        $response->execute($data);

        return $response->fetch(PDO::FETCH_ASSOC);
    }

    public static function count(array $data)
    {

        $request = "SELECT COUNT(id) FROM chapter WHERE id_story = :id_story";
        $response = self::getDb()->prepare($request);
        $response->execute($data);

        return $response->fetch(PDO::FETCH_ASSOC);
    }
}
