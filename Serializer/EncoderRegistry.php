<?php
/**
 * SimpleThings FormExtraBundle
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace SimpleThings\FormExtraBundle\Serializer;

class EncoderRegistry
{
    private $encoders = array();

    public function __construct(array $encoders)
    {
        $this->encoders = $encoders;
    }

    public function supportsEncoding($format)
    {
        foreach ($this->encoders as $encoder) {
            if ($encoder->supportsEncoding($format)) {
                return true;
            }
        }

        return false;
    }

    public function getEncoder($format)
    {
        foreach ($this->encoders as $encoder) {
            if ($encoder->supportsEncoding($format)) {
                return $encoder;
            }
        }

        throw new \RuntimeException("No encoder for $format");
    }
}

