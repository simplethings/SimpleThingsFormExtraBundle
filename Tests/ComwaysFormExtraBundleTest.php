<?php

namespace Comways\FormExtraBundle\Tests;

use Comways\FormExtraBundle\ComwaysFormExtraBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ComwaysFormExtraBundleTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $container = new ContainerBuilder();
        $bundle = new ComwaysFormExtraBundle();

        $bundle->build($container);

        $passes = $container->getCompilerPassConfig()->getBeforeOptimizationPasses();

        $this->assertEquals(1, count($passes));
        $this->assertInstanceOf('Comways\FormExtraBundle\DependencyInjection\Compiler\TwigFormPass', $passes[0]);
    }
}
