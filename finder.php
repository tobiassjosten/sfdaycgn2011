<?php

require_once __DIR__.'/autoload.php';

use Symfony\Component\Finder\Finder;

$path = __DIR__.'/symfony/src';

$finder = new Finder();
$result = $finder
    ->in($path)
    ->name('*.php')
    ->size('>10k')
    ->date('> 2 days ago')
;

foreach ($finder as $file) {
    print $file."\n";
    print $path.$file->getRelativePath()."\n";
    exit;
}
