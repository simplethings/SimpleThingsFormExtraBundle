<?php

namespace SimpleThings\FormExtraBundle\Tests\Form\Type;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormView;
use SimpleThings\FormExtraBundle\Form\Type\RecaptchaType;
use SimpleThings\FormExtraBundle\Service\Recaptcha;

class RecaptchaFormTypeTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->type = new RecaptchaType(
            new Recaptcha(
                new Request(),
                'privateKey'
            ),
            'publicKey'
        )
        ;
        $this->dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $this->factory = $this->getMock('Symfony\Component\Form\FormFactoryInterface');
        $this->builder = new FormBuilder('name', null, $this->dispatcher, $this->factory);
    }

    public function testNameAndParent()
    {
        $this->assertEquals('formextra_recaptcha', $this->type->getName());
        $this->assertEquals('form', $this->type->getParent(array()));
    }

    public function testDefaultOptions()
    {
        $options = new \Symfony\Component\OptionsResolver\OptionsResolver();
        $this->type->setDefaultOptions($options);

        $this->assertEquals(array(
            'property_path' => false,
            'required' => true,
            'widget_options' => array(),
        ), $options->resolve());
    }

    public function testBuildForm()
    {
        $this->type->buildForm($this->builder, array(
            'widget_options' => array(
                'theme' => 'white'
            ),
        ));

        $this->assertTrue($this->builder->has('recaptcha_challenge_field'));
        $this->assertTrue($this->builder->has('recaptcha_response_field'));
        
        $transformers = $this->builder->getViewTransformers();
        $this->assertEquals(1, count($transformers));
        $this->assertInstanceOf('SimpleThings\FormExtraBundle\Form\DataTransformer\RecaptchaTransformer', $transformers[0]);
    }

    public function testBuildView()
    {
        $view = new FormView();

        $this->builder->setAttribute('widget_options', array(
            'theme' => 'white',
        ));

        $this->type->buildView($view, $this->builder->getForm(), array(
                'widget_options' => array(
                    'theme' => 'white'
                ),
            ));

        $this->assertEquals('publicKey', $view->vars['public_key']);
        $this->assertEquals(array(
            'theme' => 'white',
        ), $view->vars['widget_options']);
    }
}
