<?php

namespace SimpleThings\FormExtraBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilderInterface;

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
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setAttribute('translation_domain', $options['translation_domain']);
    }

    /**
     * @param FormView      $view
     * @param FormInterface $form
     * @param array         $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->set('translation_domain', $form->getAttribute('translation_domain'));
    }

    /**
     * @param array $options
     *
     * @return array
     */
    public function getDefaultOptions()
    {
        return array(
            'translation_domain' => 'messages',
        );
    }
}
