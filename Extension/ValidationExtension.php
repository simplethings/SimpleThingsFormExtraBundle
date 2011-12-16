<?php

namespace Symfony\Bridge\Twig\Extension;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 *
 * @author David Badura <badura@simplethings.de>
 */
class ValidationExtension extends \Twig_Extension
{
    
    /**
     *
     * @var ValidatorInterface 
     */
    private $validation;
    
    private $objects;

    public function __construct(ValidatorInterface $validation, array $objects)
    {
        $this->validation = $validation;
        $this->objects = $objects;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return array(
            'simplethings_formextra_validation'  => new \Twig_Function_Method($this, 'getValidationConstraints'),
        );
    }

    public function getValidationConstraints()
    {
        
        $metadataFactory = $this->validation->getMetadataFactory();
        
        foreach($objects as $object) {
            $metadata = $metadataFactory->getClassMetadata($object);
            $properties = $metadata->getConstrainedProperties();
            
            var_dump($properties);
            
        }
        
        
        
        
        
        
        
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
