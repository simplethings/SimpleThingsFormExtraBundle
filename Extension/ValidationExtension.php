<?php

namespace SimpleThings\FormExtraBundle\Extension;

use Symfony\Component\Validator\ValidatorInterface;

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
    private $validator;
    
    private $objects;

    public function __construct(ValidatorInterface $validator, array $objects)
    {
        $this->validator = $validator;
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
            'simplethings_formextra_validation'  => new \Twig_Function_Method($this, 'getValidationConstraints', array('is_safe' => array('html'))),
        );
    }

    public function getValidationConstraints()
    {
        
        $metadataFactory = $this->validator->getMetadataFactory();
        $data = array();
        
        foreach($this->objects as $object) {
            $data[$object] = array();
            
            $metadata = $metadataFactory->getClassMetadata($object);
            $properties = $metadata->getConstrainedProperties();
            
            foreach($properties as $propertie) {
                $data[$object][$propertie] = array();
                $constraints = $metadata->getMemberMetadatas($propertie);
                foreach($constraints[0]->constraints as $constraint) {
                   $data[$object][$propertie][$this->getConstraintName($constraint)] = $constraint;
                }
            }
        }
        
        return \json_encode($data);
        
    }
    
    protected function getConstraintName($constraint) {
        $class = \get_class($constraint);
        $parts = \explode('\\', $class);
        return \lcfirst(\array_pop($parts));
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
