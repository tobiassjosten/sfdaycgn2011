<?php

require_once __DIR__.'/autoload.php';

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RequestContext;


$routes = new RouteCollection();
$routes->add('hello', new Route('/hello', array('name' => 'World')));
$routes->add('hello2', new Route('/hello/{name}', array('name' => 'World')));

$routes->add('hello2', new Route('/dir'));
$routes->add('hello2', new Route('/dir/'));

$context = new RequestContext();

$matcher = new UrlMatcher($routes, $context);

print_r($matcher->match('/hello'));
print_r($matcher->match('/hello/Tobias'));
print_r($matcher->match('/foor-bar'));
