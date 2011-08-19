<?php

namespace SimpleThings\FormExtraBundle\Service;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class for abstrating calling Recaptcha out of the DataTransformer
 * so it can be test with a mock of this class.
 *
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 */
class Recaptcha
{
    /**
     * @var Request $request
     */
    protected $request;

    /**
     * @var string $privateKey
     */
    protected $privateKey;

    /**
     * @param Request $request
     * @param string $privateKey
     */
    public function __construct(Request $request, $privateKey)
    {
        $this->request = $request;
        $this->privateKey = $privateKey;
    }

    /**
     * Uses a stream context to call the api and validating the recaptcha
     * parameters
     *
     * @param string $challenge
     * @param string $response
     */
    public function isValid($challenge = null, $response = null)
    {
        $parameters = array(
            'remoteip'    => $this->request->server->get('REMOTE_ADDR', '127.0.0.1'),
            'privatekey'  => $this->privateKey,
            'response'    => $this->request->get('recaptcha_response_field', $response),
            'challenge'   => $this->request->get('recaptcha_challenge_field', $challenge),
        );

        $context = stream_context_create(array(
            'http' => array(
                'method'  => 'POST',
                'content' => http_build_query($parameters),
                'header'  => array(
                    'Content-Type: application/x-www-form-urlencoded',
                ),
            ),
        ));

        $result = file_get_contents('http://www.google.com/recaptcha/api/verify', false, $context);

        if (false !== strpos($result, 'true', 0)) {
            return true;
        }

        return false;
    }
}
