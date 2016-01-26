<?php
namespace Blog\Domain\Interactor;

use Blog\Domain\Gateway\Post as PostGateway;
use Blog\Domain\Entity\Post as PostEntity;

class CreateNewPost
{
    protected $postGateway;

    public function __construct(PostGateway $postGateway)
    {
        $this->postGateway = $postGateway;
    }

    public function __invoke(array $input)
    {
        $post = new PostEntity($input['title'], $input['content'], $input['excerpt']);
        $this->postGateway->savePost($post);
        return ['success' => true];
    }
}
