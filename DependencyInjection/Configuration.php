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
                ->arrayNode('recaptcha')
                    ->children()
                        ->scalarNode('public_key')->defaultValue('')->end()
                        ->scalarNode('private_key')->defaultValue('')->end()
                    ->end()
                ->end()
            ->end()
        ->end();
    }
}
