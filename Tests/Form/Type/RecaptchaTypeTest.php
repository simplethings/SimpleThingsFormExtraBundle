<?php

namespace Comways\FormExtraBundle\Tests\Form\Type;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormView;
use Comways\FormExtraBundle\Form\Type\RecaptchaType;

class RecaptchaFormTypeTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->type = new RecaptchaType(new Request());
        $this->dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $this->factory = $this->getMock('Symfony\Component\Form\FormFactoryInterface');
        $this->builder = new FormBuilder('name', $this->factory, $this->dispatcher);
    }

    public function testNameAndParent()
    {
        $this->assertEquals('recaptcha', $this->type->getName());
        $this->assertEquals('form', $this->type->getParent(array()));
    }

    public function testDefaultOptions()
    {
        $this->assertEquals(array(
            'property_path' => false,
            'private_key' => null,
            'public_key' => null,
            'required' => true,
            'widget_options' => array(),
        ), $this->type->getDefaultOptions(array()));
    }

    public function testBuildForm()
    {
        $this->type->buildForm($this->builder, array(
            'private_key' => 'my_private_key',
            'public_key' => 'my_public_key',
            'widget_options' => array(
                'theme' => 'white'
            ),
        ));

        $this->assertEquals('my_public_key', $this->builder->getAttribute('public_key'));
        $this->assertEquals(array(
            'theme' => 'white',
        ), $this->builder->getAttribute('widget_options'));

        $this->assertTrue($this->builder->has('recaptcha_challenge_field'));
        $this->assertTrue($this->builder->has('recaptcha_response_field'));
        
        $transformers = $this->builder->getClientTransformers();
        $this->assertEquals(1, count($transformers));
        $this->assertInstanceOf('Comways\FormExtraBundle\Form\DataTransformer\RecaptchaTransformer', $transformers[0]);
    }

    public function testBuildView()
    {
        $view = new FormView();

        $this->builder->setAttribute('widget_options', array(
            'theme' => 'white',
        ));
        $this->builder->setAttribute('public_key', 'my_public_key');

        $this->type->buildView($view, $this->builder->getForm());

        $this->assertEquals('my_public_key', $view->get('public_key'));
        $this->assertEquals(array(
            'theme' => 'white',
        ), $view->get('widget_options'));
    }
}
