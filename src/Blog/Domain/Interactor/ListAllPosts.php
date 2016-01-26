<?php
namespace Blog\Domain\Interactor;

use Blog\Domain\Gateway\Post as PostGateway;

class ListAllPosts
{
    protected $postGateway;

    public function __construct(PostGateway $postGateway)
    {
        $this->postGateway = $postGateway;
    }

    public function __invoke()
    {
        return [
            'success' => true,
            'posts' => $this->postGateway->getAllPosts(),
        ];
    }
}
