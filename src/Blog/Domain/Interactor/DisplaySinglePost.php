<?php
namespace Blog\Domain\Interactor;

use Blog\Domain\Gateway\Post as PostGateway;
use Exception;

class DisplaySinglePost
{
    protected $postGateway;

    public function __construct(PostGateway $postGateway)
    {
        $this->postGateway = $postGateway;
    }

    public function __invoke($id)
    {
        try {
            return [
                'success' => true,
                'post' => $this->postGateway->getPostById($id),
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
