<?php

namespace Comways\FormExtraBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * A Form type that just renders the field as a p tag. This is useful for forms where certain field
 * need to be shown but not editable.
 *
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 */
class PlainType extends AbstractType
{
    /**
     * @param array $options
     * @return array
     */
    public function getDefaultOptions(array $options)
    {
        return array(
            'read_only' => true,
            'property_path' => false,
        );
    }
}
