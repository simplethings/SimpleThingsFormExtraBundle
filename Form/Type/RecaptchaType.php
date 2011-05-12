<?php

namespace Comways\FormExtraBundle\Form\Type;

use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;

use Comways\FormExtraBundle\Form\DataTransformer\RecaptchaTransformer;

/**
 * A ReCaptcha type for use with Google ReCatpcha services. It embeds two fields that are used
 * for manual validation and show of the widget.
 *
 * The DataTransformer takes the entered request information and validates them agains the 
 * Google Recaptcha API.
 *
 * example:
 *     $builder->add('recaptcha', 'recaptcha', array(
 *         'private_key' => 'private_key_here_required',
 *         'public_key' => 'public_key_here_required',
 *     ))
 *
 *
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 */
class RecaptchaType extends \Symfony\Component\Form\AbstractType
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Configures the Type
     *
     * @param FormBuilder $builder
     * @param array       $options
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('recaptcha_challenge_field', 'text')
            ->add('recaptcha_response_field', 'hidden', array(
                'data' => 'manual_challenge',
            ))
        ;

        $builder->prependClientTransformer(new RecaptchaTransformer($this->request, $options['private_key']));

        $builder
            ->setAttribute('public_key', $options['public_key'])
            ->setAttribute('widget_options', $options['widget_options'])
        ;
    }

    /**
     * Options for this type
     *
     * @param  array $options
     * @return array
     */
    public function getDefaultOptions(array $options)
    {
        return array(
            'csrf_protection' => false,
            'required'        => false,
            'error_bubbling'  => false,
            'property_path'   => false,
            'private_key'     => null,
            'public_key'      => null,
            'widget_options'  => array(),
        );
    }

    /**
     * Sets attributes for use with the renderer
     *
     * @param FormView $view
     * @param FormInterface $form
     */
    public function buildView(FormView $view, FormInterface $form)
    {
        $view->set('public_key', $form->getAttribute('public_key'));
        $view->set('widget_options', $form->getAttribute('widget_options'));
    }

    /**
     * Because this have property_path = null and it shouldnt be written this parent
     * is a field.
     *
     * @return string
     */
    public function getParent(array $options)
    {
        return 'form';
    }

    /**
     * Used to identify the rendering block
     *
     * @return string
     */
    public function getName()
    {
        return 'recaptcha';
    }
}
