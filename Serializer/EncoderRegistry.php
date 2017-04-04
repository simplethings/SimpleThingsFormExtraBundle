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

use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class EncoderRegistry implements EncoderInterface, DecoderInterface
{
    private $encoders = array();

    public function __construct(array $encoders)
    {
        $this->encoders = $encoders;
    }

    public function supportsDecoding($format)
    {
        foreach ($this->encoders as $encoder) {
            if ($encoder->supportsDecoding($format)) {
                return true;
            }
        }

        return false;
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

    public function decode($data, $format)
    {
        $encoder = $this->getEncoder($format);
        return $encoder->decode($data, $format);
    }

    public function encode($data, $format)
    {
        $encoder = $this->getEncoder($format);
        return $encoder->encode($data, $format);
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

