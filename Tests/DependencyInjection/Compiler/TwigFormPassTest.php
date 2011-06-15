<?php

namespace SimpleThings\FormExtraBundle\DependencyInjection\Compiler;

use SimpleThings\FormExtraBundle\DependencyInjection\Compiler\TwigFormPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TwigFormPassTest extends \PHPUnit_Framework_TestCase
{
    public function testProcess()
    {
        $container = new ContainerBuilder();
        $pass = new TwigFormPass();

        $pass->process($container);
        $this->assertFalse($container->hasParameter('twig.form.resources'));

        $container = new ContainerBuilder();
        $container->setParameter('twig.form.resources', array());

        $pass->process($container);

        $this->assertEquals(array(
            'SimpleThingsFormExtraBundle:Form:div_layout.html.twig',
        ), $container->getParameter('twig.form.resources'));
    }
}
