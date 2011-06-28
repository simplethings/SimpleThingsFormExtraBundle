<?php

namespace SimpleThings\FormExtraBundle\FunctionalTest;

use SimpleThings\FormExtraBundle\Service\Recaptcha as BaseRecaptcha;

/**
 * A Recaptcha Service class that always returns true.
 * Should be used for functional testing
 *
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 */
class Recaptcha extends BaseRecaptcha
{
    /**
     * @param string $challenge
     * @param string $response
     * @return Boolean
     */
    public function isValid($challenge = null, $response = null)
    {
        return true;
    }
}
