<?php

class Bar
{
    public function drink() { echo "Great!\n"; }
}

class Foo
{
    public function __construct(Bar $bar) { $this->bar = $bar; }
    public function init(Bar $bar) { echo "Initialized!\n"; }
    public function drink() { $this->bar->drink(); }
}

require_once __DIR__.'/autoload.php';

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Parameter;

// Object description.

$container = new ContainerBuilder();

$container->register('bar', 'Bar');
$container
    ->register('foo', '%foo.class%')
    ->addArgument(new Reference('bar'))
    ->addMethodCall('init', array(new Reference('bar')))
    ;

// Configuration.

$container->setParameter('foo.class', 'Foo');

// Testing.

echo 'foo:'.spl_object_hash($container->get('foo'))."\n";
echo 'foo:'.spl_object_hash($container->get('foo'))."\n";
echo 'bar:'.spl_object_hash($container->get('bar'))."\n";

// Usage.

$container->get('foo')->drink();
