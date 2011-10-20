<?php

require_once __DIR__.'/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';

$loader = new Symfony\Component\ClassLoader\UniversalClassLoader();
$loader->register();

$loader->registerNamespace('Symfony', __DIR__.'/symfony/src');

$m = new Symfony\Component\ClassLoader\MapClassLoader();
