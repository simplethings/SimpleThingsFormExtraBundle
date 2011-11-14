<?php

if (isset($_SERVER['TRAVIS']) && !isset($_SERVER['SYMFONY'])) {
    $_SERVER['SYMFONY'] = __DIR__ . '/../vendor/symfony/src';
}

require_once $_SERVER['SYMFONY'] . '/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Symfony' => $_SERVER['SYMFONY'],
));
$loader->register();

spl_autoload_register(function($class) {
    if (0 === strpos($class, 'SimpleThings\\FormExtraBundle\\')) {
        $path = __DIR__.'/../'.implode('/', array_slice(explode('\\', $class), 2)).'.php';
        if (!stream_resolve_include_path($path)) {
            return false;
        }
        require_once $path;
        return true;
    }
});

