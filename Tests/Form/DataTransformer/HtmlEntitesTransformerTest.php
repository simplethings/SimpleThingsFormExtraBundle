<?php

namespace SimpleThings\FormExtraBundle\Tests\Form\DataTransformer;

use SimpleThings\FormExtraBundle\Form\DataTransformer\HtmlEntitiesTransformer;

class HtmlEntitiesTransformersTest extends \PHPUnit_Framework_TestCase
{
    public function testConvertingWithDefault()
    {
        $transformer = new HtmlEntitiesTransformer();
        $this->assertEquals('&lt;p&gt;this is defaults&lt;/p&gt;', $transformer->reverseTransform('<p>this is defaults</p>'));
        $this->assertEquals('What is you farther\'s name', $transformer->reverseTransform('What is you farther\'s name'));
    }

    public function testTransformDoesNothing()
    {
        $transformer = new HtmlEntitiesTransformer();
        $this->assertEquals('"', $transformer->transform('"'));
    }

    public function testOptionsGetPassedToFunction()
    {
        $transformer = new HtmlEntitiesTransformer(ENT_QUOTES);
        $this->assertEquals('What is you father&#039;s name', $transformer->reverseTransform('What is you father\'s name'));
    }
}
