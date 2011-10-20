<?php

require_once __DIR__.'/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
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
    '_controller' => function($name, $foo) {
        return new Response('Hello '.$name.' '.$foo);
    },
    'name' => 'World',
    'foo' => 'bar',
)));

$request = Request::create('/hello/Tobias');

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

$resolver = new ControllerResolver();

try {
    $request->attributes->add($matcher->match($request->getPathInfo()));

    $controller = $resolver->getController($request);
    $arguments = $resolver->getArguments($request, $controller);

    $response = call_user_func_array($controller, $arguments);
}
catch (ResourceNotFoundException $e) {
    $response = new Response('Not Found', 404);
}
catch (Exception $e) {
    $response = new Response('An error occured: '.$e->getMessage(), 500);
}


$response->send();
