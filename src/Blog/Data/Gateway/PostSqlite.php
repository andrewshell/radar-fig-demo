<?php
namespace Blog\Data\Gateway;

use Blog\Domain\Entity\Post as PostEntity;
use Blog\Domain\Gateway\Post as PostGateway;
use Exception;
use PDO;

class PostSqlite implements PostGateway
{
    private $dbh;

    public function __construct(PDO $dbh)
    {
        $this->dbh = $dbh;
    }

    public function getAllPosts()
    {
        $this->init();

        $sql = "SELECT * FROM posts ORDER BY id";
        $sth = $this->dbh->query($sql);

        $posts = array();

        while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $posts[] = $this->rowToEntity($row);
        }

        return $posts;
    }

    public function getPostById($id)
    {
        $this->init();

        $sql = "SELECT * FROM posts WHERE id = :id LIMIT 1";
        $sth = $this->dbh->prepare($sql);
        $sth->execute(['id' => $id]);

        while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            return $this->rowToEntity($row);
        }

        throw new Exception("No post found with ID: {$id}");
    }

    public function savePost(PostEntity $post)
    {
        if ($post->hasId()) {
            $this->replacePost($post);
        } else {
            $this->insertPost($post);
        }
    }

    private function insertPost(PostEntity $post)
    {
        $this->init();

        $sql = "INSERT INTO posts (
            title, content, excerpt
        ) VALUES (
            :title, :content, :excerpt
        )";

        $sth = $this->dbh->prepare($sql);
        $sth->execute([
            'title' => $post->getTitle(),
            'content' => $post->getContent(),
            'excerpt' => $post->getExcerpt(),
        ]);
    }

    private function replacePost(PostEntity $post)
    {
        $this->init();

        $sql = "REPLACE INTO posts (
            id, title, content, excerpt
        ) VALUES (
            :id, :title, :content, :excerpt
        )";

        $sth = $this->dbh->prepare($sql);
        $sth->execute([
            'id' => $post->getId(),
            'title' => $post->getTitle(),
            'content' => $post->getContent(),
            'excerpt' => $post->getExcerpt(),
        ]);
    }

    private function init()
    {
        $sql = "CREATE TABLE IF NOT EXISTS posts (
                    id INTEGER PRIMARY KEY,
                    title TEXT,
                    content TEXT,
                    excerpt TEXT
                )";

        $this->dbh->query($sql);
    }

    private function rowToEntity($row)
    {
        return new PostEntity($row['title'], $row['content'], $row['excerpt'], $row['id']);
    }
}
