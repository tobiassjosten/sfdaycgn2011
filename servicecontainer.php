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

$container = new Container();

$container->set('bar', new Bar());
$container->set('foo', new Foo($container->get('bar')));

$container->get('foo')->drink();
