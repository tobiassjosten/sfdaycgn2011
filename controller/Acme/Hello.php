<?php

namespace Acme;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class Hello
{
    public function index($name)
    {
        $response = new Response('Hello '.$name);
        $response->setTtl(10);

        return $response;
    }

    public function exception(Request $request)
    {
        return new Response('Exception: '.$request->attributes->get('exception')->getMessage(), 500);
    }
}
