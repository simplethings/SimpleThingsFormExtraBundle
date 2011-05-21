<?php

namespace Comways\FormExtraBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PlainType extends AbstractType
{
    public function getDefaultOptions(array $options)
    {
        return array(
            'read_only' => true,
            'property_path' => false,
        );
    }
}
