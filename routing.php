<?php

require_once __DIR__.'/autoload.php';

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RequestContext;


$routes1 = new RouteCollection();
$routes1->add('hello', new Route('/hello', array('name' => 'World')));
$routes1->add('hello2', new Route(
    '/hello/{name}',
    array('name' => 'World'),
    array(
        'name' => '\w{3,}',
        '_method' => 'GET',
        '_scheme' => 'https',
    )
));
$routes1->add('hello3', new Route(
    '/hello/{name}',
    array('name' => 'World')
));

$routes2 = new RouteCollection();
$routes2->add('dir1', new Route('/dir'));
$routes2->add('dir2', new Route('/dir/'));

$routes1->addCollection($routes2, '/ls');

$context = new RequestContext('', 'POST');

$matcher = new UrlMatcher($routes1, $context);

print_r($matcher->match('/hello'));
print_r($matcher->match('/hello/Tobias'));
print_r($matcher->match('/ls/dir'));
