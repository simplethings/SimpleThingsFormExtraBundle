<?php

namespace Comways\FormExtraBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Auto adds the Twig form template to the list of resources
 *
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 */
class TwigFormPass implements \Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasParameter('twig.form.resources')) {
            return;
        }

        $container->setParameter('twig.form.resources', array_merge(
            $container->getParameter('twig.form.resources'),
            array('ComwaysFormExtraBundle:Form:div_layout.html.twig')
        ));
    }
}
