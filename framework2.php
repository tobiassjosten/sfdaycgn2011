<?php

require_once __DIR__.'/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

//$request = Request::createFromGlobals();
$request = Request::create('/hello?name=Tobias');

$content = 'Hello '.$request->query->get('name', 'World');

$response = new Response($content);

echo $response;
