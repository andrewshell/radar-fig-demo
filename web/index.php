<?php
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\HttpFoundation\Request;
use Zend\Diactoros\Response as PsrResponse;
use Zend\Diactoros\ServerRequestFactory as ServerRequestFactory;

ini_set('display_errors', true);

/**
 * Bootstrapping
 */
require '../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$app['postGateway'] = function () {
    $postGateway = new \Blog\Data\Gateway\PostMemory();
    $postGateway->savePost(new \Blog\Domain\Entity\Post('Sample Post 1', 'This is the first sample post.', '', '1'));
    $postGateway->savePost(new \Blog\Domain\Entity\Post('Sample Post 2', 'This is the second sample post.', '', '2'));
    $postGateway->savePost(new \Blog\Domain\Entity\Post('Sample Post 3', 'This is the third sample post.', '', '3'));

    return $postGateway;
};

$app->get('/', function (Request $request) use ($app) {
    $psr7Factory = new DiactorosFactory();
    $psrRequest = $psr7Factory->createRequest($request);
    $psrResponse = new PsrResponse();

    $input = new \Blog\Delivery\Input\NoneExpected();
    $action = new \Blog\Domain\Interactor\ListAllPosts($app['postGateway']);
    $responder = new \Blog\Delivery\Responder\Html(__DIR__ . '/../views');

    $psrRequest = $psrRequest->withAttribute('_view', 'listposts.html.php');
    $payload = $action($input($psrRequest));

    $psrResponse = $responder($psrRequest, $psrResponse, $payload);

    $httpFoundationFactory = new HttpFoundationFactory();
    return $httpFoundationFactory->createResponse($psrResponse);
});

$app->run();
