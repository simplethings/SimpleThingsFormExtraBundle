<?php

namespace SimpleThings\FormExtraBundle\Form\Type;

use Symfony\Component\Form\AbstractType;


/**
 * A Form type that just renders the field as a p tag. This is useful for forms where certain field
 * need to be shown but not editable.
 *
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 * @author Gordon Franke <info@nevalon.de>
 */
class PlainType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'field';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultOptions(array $options)
    {
        return array(
            'read_only' => true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'formextra_plain';
    }
}
