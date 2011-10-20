<?php

require_once __DIR__.'/autoload.php';

use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();

$request->get('foo');
$request->query->get('foo', 'default');
$request->query->getInt('num', 1);
$request->request->has('foo');
$request->files->get('foo');

// ?foo[bar]=bar
$a = $request->query->get('foo');
$a['bar'];
$a = $request->query->get('foo[bar]', 1, true);

$request = Request::create('?foo=bar', 'GET');
