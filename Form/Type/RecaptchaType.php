<?php

namespace SimpleThings\FormExtraBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Exception\InvalidConfigurationException;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;

use SimpleThings\FormExtraBundle\Service\Recaptcha;
use SimpleThings\FormExtraBundle\Form\DataTransformer\RecaptchaTransformer;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
 * @author Jeffrey Boehm <post@jeffrey-boehm.de>
 */
class RecaptchaType extends AbstractType
{
    /**
     * @var Recaptcha
     */
    protected $recaptcha;

    /**
     * @var string
     */
    protected $publicKey;

    /**
     * @param Recaptcha $recaptcha
     * @param string    $publicKey
     */
    public function __construct(Recaptcha $recaptcha, $publicKey)
    {
        $this->recaptcha = $recaptcha;
        $this->publicKey = $publicKey;
    }

    /**
     * Configures the Type
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ((string) $this->publicKey === '') {
            throw new InvalidConfigurationException('A public key must be set and not empty.');
        }

        $builder
            ->add('recaptcha_challenge_field', 'text')
            ->add('recaptcha_response_field', 'hidden', array(
                'data' => 'manual_challenge',
            ));

        $builder->addViewTransformer(new RecaptchaTransformer($this->recaptcha));
    }

    /**
     * Sets attributes for use with the renderer
     *
     * @param FormView      $view
     * @param FormInterface $form
     * @param array         $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['public_key'] = $this->publicKey;
        $view->vars['widget_options'] = $options['widget_options'];
    }

    /**
     * Options for this type
     *
     * @param  array $options
     *
     * @return array
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'required'        => true,
            'property_path'   => false,
            'widget_options'  => array(),
        ));
    }

    /**
     * Because this have property_path = null and it shouldnt be written this parent
     * is a field.
     *
     * @return string
     */
    public function getParent()
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
        return 'formextra_recaptcha';
    }
}
