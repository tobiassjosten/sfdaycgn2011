<?php

class Bar
{
    public function drink() { echo "Great!\n"; }
}

class Foo
{
    public function __construct(Bar $bar) { $this->bar = $bar; }
    public function drink() { $this->bar->drink(); }
}

require_once __DIR__.'/autoload.php';

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

$container = new ContainerBuilder();

$container->register('bar', 'Bar');
$container
    ->register('foo', 'Foo')
    ->addArgument(new Reference('bar'))
;

$container->get('foo')->drink();
