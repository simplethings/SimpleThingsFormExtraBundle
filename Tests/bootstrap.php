<?php

require_once $_SERVER['SYMFONY'] . '/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Comways\\FormExtraBundle' => '../../',
    'Symfony' => $_SERVER['SYMFONY'],
));
$loader->register();
