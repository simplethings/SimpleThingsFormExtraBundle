<?php

namespace SimpleThings\FormExtraBundle\Tests\DependencyInjection;

use SimpleThings\FormExtraBundle\DependencyInjection\SimpleThingsFormExtraExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SimpleThingsFormExtraExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testLoad()
    {
        $container = new ContainerBuilder();
        $extension = new SimpleThingsFormExtraExtension();
        $extension->load(array(array(
            'recaptcha' => array(
                'private_key' => 'my_private_key',
                'public_key' => 'my_public_key',
            ),
        )), $container);

        $parameters = array(
            'form.type.recaptcha.class'  => 'SimpleThings\FormExtraBundle\Form\Type\RecaptchaType',
            'form.type.image.class'      => 'SimpleThings\FormExtraBundle\Form\Type\ImageType',
            'form.type.file_set.class'   => 'SimpleThings\FormExtraBundle\Form\Type\FileSetType',
            'form.type.plain.class'      => 'SimpleThings\FormExtraBundle\Form\Type\PlainType',
            'form.extension.field.class' => 'SimpleThings\FormExtraBundle\Form\Extension\FieldTypeExtension',
            'service.recaptcha.class'    => 'SimpleThings\FormExtraBundle\Service\Recaptcha',
        );

        foreach ($parameters as $parameter => $value) {
            $this->assertEquals($container->getParameter('simple_things_form_extra.' . $parameter), $value);
        }

        $definitions = array(
            'form.type.recaptcha',
            'form.type.image',
            'form.type.file_set',
            'form.type.plain',
            'form.extension.field',
            'service.recaptcha',
        );

        foreach ($definitions as $definition) {
            $this->assertTrue($container->hasDefinition('simple_things_form_extra.' . $definition));
        }
    }
}
