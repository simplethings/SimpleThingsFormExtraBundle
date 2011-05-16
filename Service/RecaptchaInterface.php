<?php

namespace Comways\FormExtraBundle\Service;

use Symfony\Component\HttpFoundation\Request;

/**
 * Recaptcha interface
 *
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 * @author Benjamin Eberlei <eberlei@simplethings.de>
 */
interface RecaptchaInterface
{
    /**
     * Valid captcha response?
     * 
     * @param string $challenge
     * @param string $response
     * @return bool
     */
    public function isValid($challenge = null, $response = null);
}