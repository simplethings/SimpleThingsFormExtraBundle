<?php

namespace SimpleThings\FormExtraBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilder;

/**
 * Generic extension for fields that allows any attr to be set when building
 * the form.
 *
 * @author David Badura <badura@simplethings.de>
 */
class ValidationTypeExtension extends AbstractTypeExtension
{
    private $validatedObjects = array();
    
    public function __construct($validatedObjects)
    {
        $this->validatedObjects = array_keys($validatedObjects);
    }
    
    /**
     * @return string
     */
    public function getExtendedType()
    {
        return 'field';
    }
    
    /**
     * @param FormBuilder $builder
     * @param array $options
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        if (isset($this->validatedObjects[$options['data_class']])) {
            $builder->setAttribute('data_class', $options['data_class']);
        }
    }

    /**
     * @param FormView $view
     * @param FormInterface $form
     */
    public function buildView(FormView $view, FormInterface $form)
    {
        if (isset($this->validatedObjects[$options['data_class']])) {
            $attr = $view->get('attr', array());
            $attr['data-simplethings-validation-class'] = $form->getAttribute('data_class');
            $view->set('attr', $attr);
        }
    }
}
