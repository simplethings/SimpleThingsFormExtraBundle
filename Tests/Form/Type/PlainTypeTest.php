<?php

namespace SimpleThings\FormExtraBundle\Tests\Form\Type;

use SimpleThings\FormExtraBundle\Form\Type\PlainType;
use Symfony\Component\Form\Test\TypeTestCase;

class PlainTypeTest extends TypeTestCase
{
    public function testDefaultOptions()
    {
        $data = 'test';

        $form = $this->factory->create(new PlainType(), null, array());

        $form->setData($data);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($data, $form->getData());

        $view = $form->createView();
        $this->assertEquals(true, $view->vars['read_only']);
    }
}
