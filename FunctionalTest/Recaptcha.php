<?php

namespace Comways\FormExtraBundle\FunctionalTest;

/**
 * A Recaptcha Service class that always returns true.
 * Should be used for functional testing
 *
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 */
class Recaptcha extends \Comways\FormExtraBundle\Service\Recaptcha
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
