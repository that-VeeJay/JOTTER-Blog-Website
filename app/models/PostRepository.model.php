<?php

require_once __DIR__ . '/../../config/Database.php';

class PostRepository
{
    public function getArticle($id)
    {
        $query = "
            SELECT
                posts.title,
                posts.cover_image,
                posts.content,
                posts.created_at,
                posts.category,
                users.first_name,
                users.last_name,
                users.profile_picture
            FROM
                posts
            INNER JOIN
                users ON posts.user_id = users.id
            WHERE
                posts.id = :id;

        ";
        $stmt = Database::conn()->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getHighlightPost()
    {
        $query = "
        SELECT
            posts.id AS post_id,
            posts.title,
            posts.category,
            posts.cover_image,
            posts.created_at,
            users.first_name,
            users.last_name,
            users.profile_picture
        FROM
            posts
        INNER JOIN
            users ON posts.user_id = users.id
        ORDER BY RAND()
        LIMIT 1;
        ";
        $stmt = Database::conn()->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function loadPosts()
    {
        $query = "
            SELECT
                posts.id AS post_id,
                posts.title,
                posts.category,
                posts.created_at,
                posts.cover_image,
                users.first_name,
                users.last_name,
                users.profile_picture
            FROM posts
            JOIN users ON posts.user_id = users.id
            ORDER BY posts.created_at DESC
            LIMIT 9;
        ";
        $stmt = Database::conn()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function loadMorePosts($offset)
    {
        $query = "
            SELECT
                posts.id AS post_id,
                posts.title,
                posts.category,
                posts.created_at,
                posts.cover_image,
                users.first_name,
                users.last_name,
                users.profile_picture
            FROM posts
            JOIN users ON posts.user_id = users.id
            ORDER BY posts.created_at DESC
            LIMIT 9 OFFSET :offset;
        ";
        $stmt = Database::conn()->prepare($query);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoryPost($category)
    {
        $query = "
            SELECT
                posts.id AS post_id,
                posts.title,
                posts.category,
                posts.cover_image,
                posts.created_at,
                users.first_name,
                users.last_name,
                users.profile_picture
            FROM
                posts
            INNER JOIN
                users ON posts.user_id = users.id
            WHERE
                posts.category = :category
            ORDER BY
                posts.created_at DESC
        ";
        $stmt = Database::conn()->prepare($query);
        $stmt->bindParam(':category', $category);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
