<?php

namespace Comways\FormExtraBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();

        return $builder->root('comways_form_extra')
            ->children()
                ->arrayNode('recaptcha')
                    ->children()
                        ->scalarNode('public_key')->isRequired()->end()
                        ->scalarNode('private_key')->isRequired()->end()
                    ->end()
                ->end()
            ->end()
        ->end();
    }
}
