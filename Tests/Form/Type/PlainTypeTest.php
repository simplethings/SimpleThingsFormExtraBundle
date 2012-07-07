<?php

namespace SimpleThings\FormExtraBundle\Tests\Form\Type;

use SimpleThings\FormExtraBundle\Form\Type\PlainType;

class PlainTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultOptions()
    {
        $type = new PlainType();
        $this->assertEquals(array(
            'read_only'     => true,
        ), $type->getDefaultOptions(array()));
    }
}
