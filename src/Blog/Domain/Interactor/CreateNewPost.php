<?php
namespace Blog\Domain\Interactor;

use Blog\Domain\Gateway\Post as PostGateway;
use Blog\Domain\Entity\Post as PostEntity;
use Blog\Domain\Interactor\CreateNewPost\Request as CreateNewPostRequest;

class CreateNewPost
{
    protected $postGateway;

    public function __construct(PostGateway $postGateway)
    {
        $this->postGateway = $postGateway;
    }

    public function __invoke(CreateNewPostRequest $request)
    {
        $post = new PostEntity(
            $request->getTitle(),
            $request->getContent(),
            $request->getExcerpt()
        );
        $this->postGateway->savePost($post);
        return ['success' => true];
    }
}
