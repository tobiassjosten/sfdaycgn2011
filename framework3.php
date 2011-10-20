<?php

require_once __DIR__.'/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

//$request = Request::createFromGlobals();
$request = Request::create('/hello?name=Tobias');

if ('/hello' == $request->getPathInfo()) {
    $content = 'Hello '.$request->query->get('name', 'World');
    $response = new Response($content);
}
else {
    $response = new Response('Not Found', 404);
}

$response->send();
