<?php
namespace Blog\Delivery\Responder;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Radar\Adr\Responder\ResponderAcceptsInterface;

class Html implements ResponderAcceptsInterface
{
    protected $request;

    protected $response;

    protected $viewDir;

    public function __construct($viewDir)
    {
        $this->viewDir = $viewDir;
    }

    public static function accepts()
    {
        return ['text/html'];
    }

    public function __invoke(
        Request $request,
        Response $response,
        array $payload
    ) {
        $this->request = $request;
        $this->response = $response;
        if (isset($payload['success']) && true === $payload['success']) {
            $this->success($payload);
        } else {
            $this->error($payload);
        }
        return $this->response;
    }

    protected function htmlBody(array $data)
    {
        $view = $this->request->getAttribute('_view', 'default.html.php');
        ob_start();
        if (file_exists($this->viewDir . '/' . $view)) {
            include $this->viewDir . '/' . $view;
        }
        $body = ob_get_clean();
        $this->response = $this->response->withHeader('Content-Type', 'text/html');
        $this->response->getBody()->write($body);
    }

    protected function success($payload)
    {
        $this->response = $this->response->withStatus(200);
        $this->htmlBody($payload);
    }

    protected function error($payload)
    {
        $this->response = $this->response->withStatus(500);
        $this->request = $this->request->withAttribute('_view', 'error.html.php');
        $this->htmlBody($payload);
    }
}
