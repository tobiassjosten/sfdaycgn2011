<?php

require_once __DIR__.'/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';
require_once __DIR__.'/symfony/src/Symfony/Component/ClassLoader/DebugUniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;
use Symfony\Component\ClassLoader\DebugUniversalClassLoader;
use Symfony\Component\ClassLoader\MapClassLoader;

$loader = new UniversalClassLoader();
$loader->register();

$loader->registerNamespaces(array(
    'Symfony' =>__DIR__.'/symfony/src'
));

DebugUniversalClassLoader::enable();
