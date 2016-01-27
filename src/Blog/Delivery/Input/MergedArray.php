<?php
namespace Blog\Delivery\Input;

use Psr\Http\Message\ServerRequestInterface as Request;

class MergedArray
{
    public function __invoke(Request $request)
    {
        return [array_merge(
            (array) $request->getQueryParams(), // $_GET
            (array) $request->getAttributes(), // Internal
            (array) $request->getParsedBody() // $_POST
        )];
    }
}
