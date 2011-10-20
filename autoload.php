<?php

require_once __DIR__.'/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;
use Symfony\Component\ClassLoader\MapClassLoader;

$loader = new UniversalClassLoader();
$loader->register();

$loader->registerNamespace('Symfony', __DIR__.'/symfony/src');

$m = new Symfony\Component\ClassLoader\MapClassLoader();
