<?php

namespace SimpleThings\FormExtraBundle\Tests;

use SimpleThings\FormExtraBundle\SimpleThingsFormExtraBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SimpleThingsFormExtraBundleTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $container = new ContainerBuilder();
        $bundle = new SimpleThingsFormExtraBundle();

        $bundle->build($container);

        $passes = $container->getCompilerPassConfig()->getBeforeOptimizationPasses();

        $this->assertEquals(1, count($passes));
        $this->assertInstanceOf('SimpleThings\FormExtraBundle\DependencyInjection\Compiler\TwigFormPass', $passes[0]);
    }
}
