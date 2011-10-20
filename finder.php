<?php

require_once __DIR__.'/autoload.php';

use Symfony\Component\Finder\Finder;

$finder = new Finder();
$result = $finder
    ->name('*.php')
    ->in(__DIR__.'/symfony/src')
;

foreach ($finder as $file) {
    print $file."\n";
}

print get_class($result);
