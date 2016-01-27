<?php
namespace Blog\Delivery\Input;

use Psr\Http\Message\ServerRequestInterface as Request;

class IdOnly
{
    public function __invoke(Request $request)
    {
        return [$request->getAttribute('id')];
    }
}
