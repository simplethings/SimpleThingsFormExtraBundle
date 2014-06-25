<?php

namespace SimpleThings\FormExtraBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Translation\Translator;

/**
 *
 * @author David Badura <badura@simplethings.de>
 */
class ErrorAttrTypeExtension extends AbstractTypeExtension
{

    protected $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @return string
     */
    public function getExtendedType()
    {
        return 'field';
    }

    public function buildView(FormView $view, FormInterface $form)
    {
        $errors = array();
        $fieldErrors = $form->getErrors();
        foreach ($fieldErrors as $fieldError) {
            $errors[] = $this->translator->trans($fieldError->getMessageTemplate(), $fieldError->getMessageParameters(), 'validators');
        }

        if($errors) {
            $attr = $view->get('attr');
            if(!isset($attr['data-error'])) {
                $attr['data-error'] = implode("<br>", $errors);
                $view->set('attr', $attr);
            }
        }
    }

}