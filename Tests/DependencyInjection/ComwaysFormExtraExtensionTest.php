<?php

namespace Comways\FormExtraBundle\Tests\DependencyInjection;

use Comways\FormExtraBundle\DependencyInjection\ComwaysFormExtraExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ComwaysFormExtraExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testLoad()
    {
        $container = new ContainerBuilder();
        $extension = new ComwaysFormExtraExtension();
        $extension->load(array(array(
            'recaptcha' => array(
                'private_key' => 'my_private_key',
                'public_key' => 'my_public_key',
            ),
        )), $container);

        $parameters = array(
            'form.type.recaptcha.class' => 'Comways\FormExtraBundle\Form\Type\RecaptchaType',
            'form.extension.field.class' => 'Comways\FormExtraBundle\Form\Extension\FieldTypeExtension',
            'service.recaptcha.class' => 'Comways\FormExtraBundle\Service\Recaptcha',
        );

        foreach ($parameters as $parameter => $value) {
            $this->assertEquals($container->getParameter('comways_form_extra.' . $parameter), $value);
        }

        $definitions = array(
            'form.type.recaptcha',
            'form.extension.field',
            'service.recaptcha',
        );

        foreach ($definitions as $definition) {
            $this->assertTrue($container->hasDefinition('comways_form_extra.' . $definition));
        }
    }
}
