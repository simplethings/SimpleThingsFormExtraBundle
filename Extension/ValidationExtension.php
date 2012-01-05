<?php

namespace SimpleThings\FormExtraBundle\Extension;

use SimpleThings\FormExtraBundle\Service\JsValidationConstraintsGenerator;


/**
 *
 * @author David Badura <badura@simplethings.de>
 */
class ValidationExtension extends \Twig_Extension
{
    
    /**
     *
     * @var JsValidationConstraintsGenerator 
     */
    private $generator;

    /**
     *
     * @param ValidatorInterface $validator
     * @param array $objects 
     */
    public function __construct(JsValidationConstraintsGenerator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return array(
            'simplethings_formextra_validation'  => new \Twig_Function_Method($this, 'getValidationConstraints', array('is_safe' => array('html'))),
        );
    }

    /**
     *
     * @return string
     */
    public function getValidationConstraints()
    {
        return $this->generator->generate();        
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'simplethings_formextra_validation';
    }
}