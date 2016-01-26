<?php
namespace Blog\Domain\Gateway;

use Blog\Domain\Entity\Post as PostEntity;

interface Post
{
    public function getAllPosts();
    public function getPostById($id);
    public function savePost(PostEntity $post);
}
