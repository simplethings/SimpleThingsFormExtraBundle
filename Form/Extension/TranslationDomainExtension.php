<?php

namespace SimpleThings\FormExtraBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilder;

/**
 * Extension providing forward compatibility for the handling of translation
 * domains introduced in Symfony 2.0
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class TranslationDomainExtension extends AbstractTypeExtension
{
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
        $builder->setAttribute('translation_domain', $options['translation_domain']);
    }

    /**
     * @param FormView $view
     * @param FormInterface $form
     */
    public function buildView(FormView $view, FormInterface $form)
    {
        $view->set('translation_domain', $form->getAttribute('translation_domain'));
    }

    /**
     * @param array $options
     * @return array
     */
    public function getDefaultOptions(array $options)
    {
        return array(
            'translation_domain' => 'messages',
        );
    }
}
