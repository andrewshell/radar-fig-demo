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

    public function __invoke(array $input)
    {
        try {
            return [
                'success' => true,
                'post' => $this->postGateway->getPostById($input['id']),
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
