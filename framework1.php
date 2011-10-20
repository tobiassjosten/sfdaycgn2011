<?php

require_once __DIR__.'/autoload.php';

use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();

$request->get('foo');
$request->query->get('foo', 'default');
$request->request->has('foo');
$request->files->get('foo');
