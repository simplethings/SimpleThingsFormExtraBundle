<?php

namespace SimpleThings\FormExtraBundle\Tests\Form\Type;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\File\File;
use SimpleThings\FormExtraBundle\Form\Type\ImageType;

class ImageFormTypeTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->type = new ImageType();
        $this->dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $this->factory = $this->getMock('Symfony\Component\Form\FormFactoryInterface');
        $this->builder = new FormBuilder('name', 'Symfony\Component\HttpFoundation\File\File', $this->dispatcher, $this->factory);
    }

    public function testNameAndParent()
    {
        $this->assertEquals('formextra_image', $this->type->getName());
        $this->assertEquals('file', $this->type->getParent(array()));
    }

    public function testDefaultOptions()
    {
        $this->assertEquals(array(
            'base_path'                 => false,
            'base_uri'                  => false,
            'no_image_placeholder_uri'  => '',
            'image_alt'                 => '',
            'image_width'               => false,
            'image_height'              => false,
            'type'                      => 'file',
        ), $this->type->getDefaultOptions(array()));
    }

    public function testBuildForm()
    {
        $options = array(
            'base_path'                 => '/tmp',
            'base_uri'                  => 'http://example.com',
            'no_image_placeholder_uri'  => '',
            'image_alt'                 => '',
            'image_width'               => false,
            'image_height'              => false,
        );

        $this->type->buildForm($this->builder, $options);

        $this->assertTrue($this->builder->hasAttribute('base_path'));
        $this->assertTrue($this->builder->hasAttribute('base_uri'));
        $this->assertTrue($this->builder->hasAttribute('no_image_placeholder_uri'));
        $this->assertTrue($this->builder->hasAttribute('image_alt'));
        $this->assertTrue($this->builder->hasAttribute('image_width'));
        $this->assertTrue($this->builder->hasAttribute('image_height'));
    }

    public function testBuildView()
    {
        $view = new FormView();

        $options = array(
            'base_path'                 => __DIR__,
            'base_uri'                  => 'http://example.com',
            'no_image_placeholder_uri'  => 'empty.jpg',
            'image_alt'                 => '',
            'image_width'               => false,
            'image_height'              => false,
        );

        $this->type->buildForm($this->builder, $options);

        $form = $this->builder->getForm();
        $form->setData(new File(__FILE__));
        $this->type->buildView($view, $form, array());

        $this->assertEquals('http://example.com/ImageTypeTest.php', $view->vars['image_uri']);
    }
}
