<?php

namespace SimpleThings\FormExtraBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\HttpFoundation\File\File;
use SimpleThings\FormExtraBundle\Form\DataTransformer\FileSetTransformer;

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
        $builder->prependNormTransformer(new FileSetTransformer());
        $builder->setAttribute('delete_route', $options['delete_route']);
        $builder->setAttribute('delete_id', $options['delete_id']);
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
        $view->set('files', $files);
        $view->set('delete_route', $form->getAttribute('delete_route'));
        $view->set('delete_id', $form->getAttribute('delete_id'));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'delete_route' => false,
            'delete_id' => false,
        );
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
