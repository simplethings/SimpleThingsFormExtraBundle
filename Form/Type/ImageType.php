<?php

namespace SimpleThings\FormExtraBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

/**
 * Extends the File type, upload an image but show a version of the currently uploaded image.
 *
 * @example:
 *     $builder->add('image', 'image', array(
 *         'base_path' => '/var/www/images/',
 *         'base_uri' => 'http://example.com/images/',
 *         'no_image_placeholder_uri' => 'http://example.com/images/noimage.jpg',
 *     ));
 *
 * @author Benjamin Eberlei <eberlei@simplethings.de>
 */
class ImageType extends AbstractType
{
    /**
     * Configures the Type
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!isset($options['base_path']) || !$options['base_path']) {
            throw new \InvalidArgumentException("Base Path has to be configured.");
        }
        if (!isset($options['base_uri']) || !$options['base_uri']) {
            throw new \InvalidArgumentException("Base Uri has to be configured.");
        }

        $builder->setAttribute('base_path', $options['base_path']);
        $builder->setAttribute('base_uri', $options['base_uri']);
        $builder->setAttribute('no_image_placeholder_uri', $options['no_image_placeholder_uri']);
        $builder->setAttribute('image_alt', $options['image_alt']);
        $builder->setAttribute('image_width', $options['image_width']);
        $builder->setAttribute('image_height', $options['image_height']);
    }

    /**
     * Sets attributes for use with the renderer
     *
     * @param FormView      $view
     * @param FormInterface $form
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $data = $form->getData();

        if ($data && (strpos($data->getPath(), $form->getAttribute('base_path')) === 0)) {
            /* @var $data SplFileInfo */
            $uri = str_replace(realpath($form->getAttribute('base_path')), $form->getAttribute('base_uri'), $data->getRealPath());
            if ('/' !== DIRECTORY_SEPARATOR) {
                $uri = str_replace(DIRECTORY_SEPARATOR, '/', $uri);
            }
            $view->vars['image_uri'] = $uri;
        } else if ($form->hasAttribute ('no_image_placeholder_uri') && $uri = $form->getAttribute ('no_image_placeholder_uri')) {
            $view->setAttribute('image_uri', $uri);
        }

        $view->vars['image_alt'] = $form->getAttribute('image_alt');
        $view->vars['image_height'] = $form->getAttribute('image_height');
        $view->vars['image_width'] = $form->getAttribute('image_width');
    }

    /**
     * Options for this type
     *
     * @param  array $options
     *
     * @return array
     */
    public function getDefaultOptions(array $options)
    {
        return array(
            'base_path'                 => false,
            'base_uri'                  => false,
            'no_image_placeholder_uri'  => '',
            'image_alt'                 => '',
            'image_width'               => false,
            'image_height'              => false,
            'type'                      => 'file',
        );
    }

    /**
     * Inherits from file type and adds displaying capabilities.
     *
     * @param array $options
     *
     * @return string
     */
    public function getParent()
    {
        return 'file';
    }

    /**
     * Used to identify the rendering block
     *
     * @return string
     */
    public function getName()
    {
        return 'formextra_image';
    }
}
