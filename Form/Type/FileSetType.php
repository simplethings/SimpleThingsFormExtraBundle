<?php

namespace SimpleThings\FormExtraBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\HttpFoundation\File\File;
use SimpleThings\FormExtraBundle\Form\DataTransformer\FileSetTransformer;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Extends the File type not to handle a single file, but allowing to incrementally add one more file to a set.
 *
 * @example:
 *     $builder->add('attachments', 'fileset');
 *
 * @author Benjamin Eberlei <eberlei@simplethings.de>
 */
class FileSetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new FileSetTransformer());
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $data = $form->getData();
        if ($data === null) {
            $data = array();
        } else if ($data instanceof File) {
            $data = array($data);
        }

        if (!is_array($data)) {
            throw new UnexpectedTypeException($data, 'array');
        }

        $files = array();
        foreach ($data as $file) {
            if ($file instanceof File) {
                $files[] = basename($file->getPath());
            } else if (is_string($file)) {
                $files[] = basename($file);
            } else {
                throw new UnexpectedTypeException($file, 'string');
            }
        }
        $view->vars['files'] = $files;
        $view->vars['delete_route'] = $options['delete_route'];
        $view->vars['delete_id'] = $options['delete_id'];
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'delete_route' => false,
            'delete_id' => false,
        ));
    }

    public function getName()
    {
        return 'formextra_fileset';
    }

    public function getParent()
    {
        return 'file';
    }
}
