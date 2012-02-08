<?php
/**
 * SimpleThings FormExtraBundle
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

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
                ->booleanNode('translation_domain_forward_compat')->defaultFalse()->end()
                ->booleanNode('help_extension')->defaultFalse()->end()
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
