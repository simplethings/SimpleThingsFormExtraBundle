<?php

namespace Comways\FormExtraBundle\Service;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class for abstrating calling Recaptcha out of the DataTransformer
 * so it can be test with a mock of this class.
 *
 * @author Benjamin Eberlei <eberlei@simplethings.de>
 */
class AlwaysValidRecaptcha implements RecaptchaInterface
{
    /**
     * Valid captcha response?
     * 
     * @param string $challenge
     * @param string $response
     * @return bool
     */
    public function isValid($challenge = null, $response = null)
    {
        return true;
    }
}