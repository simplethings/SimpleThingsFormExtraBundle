<?php

namespace Comways\FormExtraBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilder;
use Comways\FormExtraBundle\Form\DataTransformer\HoneypotTransformer;

class HoneypotFormTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        if ($options['honeypot_enabled']) {
            $builder->add('honningkrukke', 'text', array(
                'property_path' => false,
                'attr' => array(
                    'class' => $options['honeypot_class'],
                ),
            ));

            $builder->get('honningkrukke')->prependNormTransformer(new HoneypotTransformer());
        }
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'honeypot_enabled' => false,
            'honeypot_class' => 'honningkrukke',
        );
    }

    public function getAllowedOptionValue(array $options)
    {
        return array(
            'honeypot_enabled' => 'boolean',
            'honeypot_class' => 'string',
        );
    }

    public function getExtendedType()
    {
        return 'form';
    }
}
