<?php

namespace Comways\FormExtraBundle\Form\DataTransformer;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\DataTransformer\TransformationFailedException;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Transforms the request into the right fields for validating the
 * recaptcha field.
 *
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 */
class RecaptchaTransformer implements DataTransformerInterface
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var string
     */
    protected $privateKey;

    /**
     * @param Request $request
     * @param string  $privateKey
     */
    public function __construct(Request $request, $privateKey)
    {
        $this->request    = $request;
        $this->privateKey = $privateKey;
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
     * @param  array $array
     * @return array
     */
    public function reverseTransform($array)
    {
        $request = $this->request->request;
        $params  = array(
            'remoteip'   => $this->request->server->get('REMOVE_ADDR', '127.0.0.1'),
            'privatekey' => $this->privateKey,
            'challenge'  => $request->get('recaptcha_challenge_field', $array['recaptcha_challenge_field']), 
            'response'   => $request->get('recaptcha_response_field', $array['recaptcha_response_field']),
        );

        $context = stream_context_create(array(
            'http' => array(
                'method'  => 'POST',
                'content' => http_build_query($params),
                'header'  => array(
                    'Content-Type: application/x-www-form-urlencoded',
                ),
            ),
        ));

        $result = file_get_contents('http://www.google.com/recaptcha/api/verify', false, $context);

        if (false !== strpos($result, 'true', 0)) {
            return array(
                'recaptcha_response_field'  => 'manual_challenge',
                'recaptcha_challenge_field' => '',
            );
        }

        throw new TransformationFailedException('The entered Recaptcha code is invalid');
    }
}

