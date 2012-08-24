<?php

namespace SimpleThings\FormExtraBundle\Tests\Form\Type;

use SimpleThings\FormExtraBundle\Form\Type\PlainType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlainTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultOptions()
    {
        $resolver = new OptionsResolver();
        $type = new PlainType();
        $type->setDefaultOptions($resolver);

        $this->assertEquals(array(
            'read_only'     => true,
        ), $resolver->resolve(array()));
    }
}
