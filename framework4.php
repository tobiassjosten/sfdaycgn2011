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

$routes = new RouteCollection();
$routes->add('hello', new Route('/hello/{name}'), array('name' => 'World'));

//$request = Request::createFromGlobals();
$request = Request::create('/hello/Tobias');

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

$request->attributes->add($matcher->match($request->getPathInfo()));

if ('hello' == $request->attributes->get('_route')) {
    $content = 'Hello '.$request->get('name');
    $response = new Response($content);
}
else {
    $response = new Response('Not Found', 404);
}

$response->send();
