<?php

namespace Comways\FormExtraBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class HoneypotTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        return $value;
    }

    public function reverseTransform($value)
    {
        if (null === $value) {
            return $value;
        }

        throw new TransformationFailedException('Honeypot field should not contain any value');
    }
}
