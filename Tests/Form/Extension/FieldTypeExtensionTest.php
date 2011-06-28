<?php

namespace SimpleThings\FormExtraBundle\Tests\Form\Extension;

use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilder;
use SimpleThings\FormExtraBundle\Form\Extension\FieldTypeExtension;

class FieldTypeExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->extension = new FieldTypeExtension();
        $this->dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $this->factory = $this->getMock('Symfony\Component\Form\FormFactoryInterface');
        $this->builder = new FormBuilder('name', $this->factory, $this->dispatcher);
    }

    public function testExtendedType()
    {
        $this->assertEquals('field', $this->extension->getExtendedType());
    }

    public function testBuildForm()
    {
        $this->extension->buildForm($this->builder, array(
            'attr' => array(
                'class' => 'something',
            ),
        ));

        $this->assertEquals(array(
            'class' => 'something',
        ), $this->builder->getAttribute('attr'));
    }

    public function testBuildView()
    {
        $view = new FormView();

        $this->builder->setAttribute('attr', array(
            'class' => 'something',
        ));
        $this->extension->buildView($view, $this->builder->getForm());

        $this->assertEquals(array(
            'class' => 'something',
        ), $view->get('attr'));
    }

    public function testDefaultOptions()
    {
        $this->assertEquals($this->extension->getDefaultOptions(array()), array(
            'attr' => array(),
        ));
    }
}
