<?php

require_once __DIR__.'/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\HttpCache\HttpCache;
use Symfony\Component\HttpKernel\HttpCache\Store;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCompiler;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Matcher\Dumper\PhpMatcherDumper;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\EventListener\ResponseListener;
use Symfony\Component\HttpKernel\EventListener\ExceptionListener;
use Symfony\Component\EventDispatcher\EventDispatcher;

// Configuration.

class Hello
{
    public function index($name)
    {
        throw new \Exception('Foo Bar');

        $response = new Response('Hello '.$name);
        $response->setTtl(10);

        return $response;
    }

    public function exception(Request $request)
    {
        return new Response('Exception: '.$request->attributes->get('exception')->getMessage(), 500);
    }
}

$routes = new RouteCollection();
$routes->add('hello1', new Route('/hello1/{name}', array(
    '_controller' => 'Hello::index',
    'name' => 'World',
    'foo' => 'bar',
)));

class Framework implements HttpKernelInterface
{
    public function __construct(UrlMatcher $matcher, ControllerResolver $resolver)
    {
        $this->matcher = $matcher;
        $this->resolver = $resolver;
    }

    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));

            $controller = $this->resolver->getController($request);
            $arguments = $this->resolver->getArguments($request, $controller);

            return call_user_func_array($controller, $arguments);
        }
        catch (ResourceNotFoundException $e) {
            return new Response('Not Found', 404);
        }
        catch (Exception $e) {
            return new Response('An error occured: '.$e->getMessage(), 500);
        }
    }
}

$request = Request::create('/hello1/Tobias', 'HEAD');

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new RouterListener($matcher));
$dispatcher->addSubscriber(new ResponseListener('UTF-8'));
$dispatcher->addSubscriber(new ExceptionListener('Hello::exception'));

$resolver = new ControllerResolver();

$framework = new HttpKernel($dispatcher, $resolver);

$store = new Store(__DIR__.'/cache');
$framework = new HttpCache($framework, $store);

$response = $framework->handle($request);
echo $response;
