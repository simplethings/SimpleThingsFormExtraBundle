<?php

namespace Comways\FormExtraBundle\Tests\Form\Type;

use Comways\FormExtraBundle\Form\Type\PlainType;

class PlainTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultOptions()
    {
        $type = new PlainType();
        $this->assertEquals(array(
            'property_path' => false,
            'read_only'     => true,
        ), $type->getDefaultOptions(array()));
    }
}
