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
$routes->add('hello', new Route('/hello/{name}'));

//$request = Request::createFromGlobals();
$request = Request::create('/hello/Tobias');

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

$parameters = $matcher->match($request->getPathInfo());

print_r($parameters);
exit;

if ('/hello' == $request->getPathInfo()) {
    $content = 'Hello '.$request->query->get('name', 'World');
    $response = new Response($content);
}
else {
    $response = new Response('Not Found', 404);
}

$response->send();
