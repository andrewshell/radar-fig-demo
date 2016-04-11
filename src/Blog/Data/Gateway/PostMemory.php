<?php
namespace Blog\Data\Gateway;

use Blog\Domain\Entity\Post as PostEntity;
use Blog\Domain\Gateway\Post as PostGateway;
use Exception;

class PostMemory implements PostGateway
{
    private $posts = array();

    public function getAllPosts()
    {
        return $this->posts;
    }

    public function getPostById($id)
    {
        foreach ($this->posts as $idx => $existing) {
            if (0 === strcmp($existing->getId(), $id)) {
                return $this->posts[$idx];
            }
        }
        throw new Exception("No post found with ID: {$id}");
    }

    public function savePost(PostEntity $post)
    {
        if (!$post->hasId()) {
            $post = $post->withId(uniqid());
        }
        foreach ($this->posts as $idx => $existing) {
            if ($post->sameIdAs($existing)) {
                $this->posts[$idx] = $post;
                return;
            }
        }
        $this->posts[] = $post;
    }
}
