<?php

namespace SimpleThings\FormExtraBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();

        return $builder->root('simple_things_form_extra')
            ->children()
                ->arrayNode('client_validation')
                    ->canBeUnset()
                    ->children()
                        ->arrayNode('objects')
                            ->prototype('scalar')->end()
                        ->end()
                   ->end()
                ->end()
                ->arrayNode('recaptcha')
                    ->canBeUnset()
                    ->children()
                        ->scalarNode('public_key')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('private_key')->isRequired()->cannotBeEmpty()->end()
                    ->end()
                ->end()
            ->end()
        ->end();
    }
}
