<?php

namespace SimpleThings\FormExtraBundle\Tests\Form\DataTransformer;

use SimpleThings\FormExtraBundle\Form\DataTransformer\StripTagsTransformer;

class StripTagsTransformerTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructorArgumentArePassedToFunction()
    {
        $transformer = new StripTagsTransformer('<p>');
        $this->assertEquals('<p>Hejsalink</p>', $transformer->reverseTransform('<p>Hejsa<a href="#">link</a></p>'));
    }

    public function testStripAllTagsByDefault()
    {
        $transformer = new StripTagsTransformer();
        $this->assertEquals('hejsa', $transformer->reverseTransform('<p>hejsa</p>'));
    }

    public function testTransformDoesNothing()
    {
        $transformer = new StripTagsTransformer();
        $this->assertEquals('<p>hejsa</p>', $transformer->transform('<p>hejsa</p>'));
    }
}
