<?php

namespace Comways\FormExtraBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

class ComwaysFormExtraExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('form_extra.xml');

        $processor = new Processor();
        $config = $processor->processConfiguration(new Configuration(), $configs);

        $container->getDefinition('comways_form_extra.service.recaptcha')->replaceArgument(1, $config['private_key']);
        $contianer->getDefinition('comways_form_extra.form.type.recaptcha')->replaceArgument(1, $config['public_key']);
    }
}

