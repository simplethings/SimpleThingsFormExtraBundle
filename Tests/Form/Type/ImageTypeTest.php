<?php

namespace SimpleThings\FormExtraBundle\Tests\Form\Type;

use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\File\File;
use SimpleThings\FormExtraBundle\Form\Type\ImageType;

class ImageFormTypeTest extends TypeTestCase
{
    /**
     * @var ImageType
     */
    protected $type;

    public function setUp()
    {
        $this->type = new ImageType('base');
        parent::setUp();
    }

    public function testNameAndParent()
    {
        $this->assertEquals('formextra_image', $this->type->getName());
        $this->assertEquals('file', $this->type->getParent(array()));
    }

    public function testDefaultOptions()
    {
        $file = new File(__FILE__);

        $form = $this->factory->create($this->type, null, array(
                'base_path' => 'base/path',
                'base_uri' => 'path',
            ));

        $form->setData($file);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($file, $form->getData());

        $view = $form->createView();
        $this->assertEquals('', $view->vars['image_alt']);
        $this->assertEquals(false, $view->vars['image_width']);
        $this->assertEquals(false, $view->vars['image_height']);
        $this->assertEquals('file', $view->vars['type']);
    }

    public function testBuildForm()
    {
        $file = new File(__FILE__);
        $form = $this->factory->create($this->type, null, array(
                'base_path' => __DIR__,
                'base_uri' => basename(__DIR__),
                'image_alt'                 => 'alt',
                'image_width'               => 10,
                'image_height'              => 10,
            ));

        $form->setData($file);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($file, $form->getData());

        $view = $form->createView();
        $this->assertEquals('alt', $view->vars['image_alt']);
        $this->assertEquals(10, $view->vars['image_width']);
        $this->assertEquals(10, $view->vars['image_height']);
        $this->assertEquals(basename($file->getPath()).'/'.$file->getFilename(), $view->vars['image_uri']);
    }

    public function testBuildView()
    {
        $file = new File(__FILE__);
        $form = $this->factory->create($this->type, null, array(
            'base_path'                 => __DIR__,
            'base_uri'                  => 'http://example.com',
            'no_image_placeholder_uri'  => 'empty.jpg',
            'image_alt'                 => '',
            'image_width'               => false,
            'image_height'              => false,
        ));

        $form->setData($file);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($file, $form->getData());

        $view = $form->createView();
        $this->assertEquals('http://example.com/ImageTypeTest.php', $view->vars['image_uri']);
    }
}
