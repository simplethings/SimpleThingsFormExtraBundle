<?php

namespace Comways\FormExtraBundle\Tests\FunctionalTest;

use Comways\FormExtraBundle\FunctionalTest\Recaptcha;
use Symfony\Component\HttpFoundation\Request;

class RecaptchaTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->recaptcha = new Recaptcha(new Request(), 'my-public-key');
    }

    public function testItAlwaysReturnTrue()
    {
        for ($i = 0;$i < 10;$i++) {
            $this->assertTrue($this->recaptcha->isValid(uniqid(), uniqid()));
        }
    }
}
