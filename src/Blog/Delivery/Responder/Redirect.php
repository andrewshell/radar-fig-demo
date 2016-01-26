<?php
namespace Blog\Delivery\Responder;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Radar\Adr\Responder\ResponderAcceptsInterface;

class Redirect extends Html
{
    protected function success($payload)
    {
        $redirect = $this->request->getAttribute('_redirect', '/');
        $this->response = $this->response->withStatus(301);
        $this->response = $this->response->withHeader('Location', $redirect);
    }
}
