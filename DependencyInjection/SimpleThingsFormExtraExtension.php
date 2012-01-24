<?php

namespace SimpleThings\FormExtraBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

class SimpleThingsFormExtraExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('form_extra.xml');

        $processor = new Processor();
        $config = $processor->processConfiguration(new Configuration(), $configs);

        if ($config['help_extension']) {
            $loader->load('field_type_help.xml');
        }

        if ($config['translation_domain_forward_compat']) {
            $loader->load('translation_domain.xml');
        }

        if (isset($config['recaptcha'])) {
            $loader->load('form_extra_recaptcha.xml');
            $container->getDefinition('simple_things_form_extra.service.recaptcha')->replaceArgument(1, $config['recaptcha']['private_key']);
            $container->getDefinition('simple_things_form_extra.form.type.recaptcha')->replaceArgument(1, $config['recaptcha']['public_key']);
        }
    }

    public function getAlias()
    {
        return 'simple_things_form_extra';
    }
}

