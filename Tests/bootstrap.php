<?php

require_once $_SERVER['SYMFONY'] . '/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'SimpleThings\\FormExtraBundle' => '../../',
    'Symfony' => $_SERVER['SYMFONY'],
));
$loader->register();

spl_autoload_register(function($class) {
    if (0 === strpos($class, 'SimpleThings\\FormExtraBundle')) {
        $file = dirname(__DIR__).str_replace('\\', DIRECTORY_SEPARATOR, substr($class, strlen('SimpleThings\\FormExtraBundle'))) . '.php';
        if (file_exists($file)) {
            require $file;
        }
    }
}, true);
