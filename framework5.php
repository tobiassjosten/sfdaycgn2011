<?php

require_once __DIR__.'/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCompiler;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Matcher\Dumper\PhpMatcherDumper;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

// Configuration.

$routes = new RouteCollection();
$routes->add('hello', new Route('/hello/{name}', array(
    '_controller' => function($request) {
        return new Response('Hello '.$request->get('name'));
    },
    'name' => 'World',
)));

$request = Request::create('/hello/Tobias');

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

try {
    $request->attributes->add($matcher->match($request->getPathInfo()));

    $response = call_user_func(
        $request->attributes->get('_controller'),
        $request
    );
}
catch (ResourceNotFoundException $e) {
    $response = new Response('Not Found', 404);
}
catch (Exception $e) {
    $response = new Response('An error occured', 500);
}


$response->send();
