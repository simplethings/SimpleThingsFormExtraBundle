<?php

namespace SimpleThings\FormExtraBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use SimpleThings\FormExtraBundle\DependencyInjection\Compiler\TwigFormPass;

class SimpleThingsFormExtraBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new TwigFormPass());
    }
}
