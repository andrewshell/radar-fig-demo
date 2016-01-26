<?php
namespace Blog\Delivery;

use Psr\Http\Message\ServerRequestInterface as Request;

class Input
{
    public function __invoke(Request $request)
    {
        return [
            array_merge(
                (array) $request->getQueryParams(), // $_GET
                (array) $request->getAttributes(), // Internal
                (array) $request->getParsedBody() // $_POST
            )
        ];
    }
}
