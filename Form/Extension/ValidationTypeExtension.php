<?php

namespace SimpleThings\FormExtraBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilder;

/**
 *
 * @author David Badura <badura@simplethings.de>
 */
class ValidationTypeExtension extends AbstractTypeExtension
{
    private $validatedObjects = array();

    public function __construct($validatedObjects)
    {
        $this->validatedObjects = array_flip($validatedObjects);
    }

    /**
     * @return string
     */
    public function getExtendedType()
    {
        return 'form';
    }

    /**
     * @param FormBuilder $builder
     * @param array $options
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        if (isset($this->validatedObjects[$options['data_class']])) {
            $attr = $builder->getAttribute('attr');
            if(!isset($attr['data-simplethings-validation-class'])) {
                $attr['data-simplethings-validation-class'] = $options['data_class'];
                $builder->setAttribute('attr', $attr);
            }
        }
    }

}