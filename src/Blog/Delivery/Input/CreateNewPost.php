<?php
namespace Blog\Delivery\Input;

use Blog\Domain\Interactor\CreateNewPost\Request as CreateNewPostRequest;
use Psr\Http\Message\ServerRequestInterface as Request;

class CreateNewPost
{
    public function __invoke(Request $request)
    {
        $post = (array) $request->getParsedBody();
        $createPostRequest = new CreateNewPostRequest(
            $post['title'],
            $post['content'],
            $post['excerpt']
        );
        return [$createPostRequest];
    }
}
