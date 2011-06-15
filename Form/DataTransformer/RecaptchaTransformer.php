<?php

namespace SimpleThings\FormExtraBundle\Form\DataTransformer;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\DataTransformerInterface;

use SimpleThings\FormExtraBundle\Service\Recaptcha;

/**
 * Transforms the request into the right fields for validating the
 * recaptcha field.
 *
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 */
class RecaptchaTransformer implements DataTransformerInterface
{
    protected $recaptcha;

    /**
     * @param Recaptcha $recaptcha
     */
    public function __construct(Recaptcha $recaptcha)
    {
        $this->recaptcha = $recaptcha;
    }

    /**
     * @param  mixed $value
     * @return mixed
     */
    public function transform($value)
    {
        return $value;
    }

    /**
     * Transforms the value from the request and validates the fields according to the api
     *
     * @param  array $data
     * @return array
     */
    public function reverseTransform($data)
    {
        $data = array_replace(array(
            'recaptcha_challenge_field' => null,
            'recaptcha_response_field'  => null,
        ), $data);


        if ($this->recaptcha->isValid($data['recaptcha_challenge_field'], $data['recaptcha_response_field'])) {
            return array(
                'recaptcha_response_field'  => 'manual_challenge',
                'recaptcha_challenge_field' => '',
            );
        }

        throw new TransformationFailedException('The entered Recaptcha code is invalid');
    }
}
