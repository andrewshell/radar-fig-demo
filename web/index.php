<?php
use Radar\Adr\Boot;
use Zend\Diactoros\Response as Response;
use Zend\Diactoros\ServerRequestFactory as ServerRequestFactory;

ini_set('display_errors', true);

/**
 * Bootstrapping
 */
require '../vendor/autoload.php';

$boot = new Boot();
$adr = $boot->adr([
    'Blog\Delivery\Config',
]);

/**
 * Run
 */
$adr->run(ServerRequestFactory::fromGlobals(), new Response());
