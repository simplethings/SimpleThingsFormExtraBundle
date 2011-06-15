<?php

namespace SimpleThings\FormExtraBundle\Tests\Form\DataTransformer;

use Symfony\Component\HttpFoundation\Request;
use SimpleThings\FormExtraBundle\Form\DataTransformer\RecaptchaTransformer;

class RecaptchaTransformerTest extends \PHPUnit_Framework_TestCase
{
    public function testTransformIsUseless()
    {
        $transformer = new RecaptchaTransformer($this->getRecaptchaMock());
        $this->assertEquals('content', $transformer->transform('content'));
    }

    /**
     * @expectedException Symfony\Component\Form\Exception\TransformationFailedException
     */
    public function testReverseTransformThrowsExceptionWhenInvalid()
    {
        $recaptcha = $this->getRecaptchaMock();
        $recaptcha
            ->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(false));
        ;

        $transformer = new RecaptchaTransformer($recaptcha);
        $transformer->reverseTransform(array(
            'challenge' => 'challenge-kye',
            'response' => 'response-key',
        ));
    }

    public function testReverseTransformReturnsArrayWhenValid()
    {
        $recaptcha = $this->getRecaptchaMock();
        $recaptcha
            ->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        ;
        $transformer = new RecaptchaTransformer($recaptcha);
        $this->assertEquals(array(
            'recaptcha_response_field' => 'manual_challenge',
            'recaptcha_challenge_field' => '',
        ), $transformer->reverseTransform(array(
            'challenge' => 'challenge-kye',
            'response' => 'response-key',
        )));
    }

    protected function getRecaptchaMock()
    {
        return $this->getMock('SimpleThings\FormExtraBundle\Service\Recaptcha', array(
            'isValid'
        ), array(new Request(), 'my-public-key'));
    }
}
