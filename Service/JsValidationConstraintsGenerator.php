<?php

namespace SimpleThings\FormExtraBundle\Service;

use Symfony\Component\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraint;

/**
 * @author david badura <badura@simplethings.de>
 */
class JsValidationConstraintsGenerator
{

    protected $objects;
    protected $validator;

    /**
     *
     * @param ValidatorInterface $validator
     * @param array $objects 
     */
    public function __construct(ValidatorInterface $validator, array $objects = array())
    {
        $this->validator = $validator;
        $this->objects = $objects;
    }

    /**
     *
     * @return string
     */
    public function generate()
    {

        $metadataFactory = $this->validator->getMetadataFactory();
        $data = array();

        foreach ($this->objects as $object) {
            $data[$object] = array();

            $metadata = $metadataFactory->getClassMetadata($object);
            $properties = $metadata->getConstrainedProperties();

            foreach ($properties as $property) {
                $data[$object][$property] = array();
                $constraintsList = $metadata->getMemberMetadatas($property);
                foreach ($constraintsList as $constraints) {
                    foreach ($constraints->constraints as $constraint) {
                        $data[$object][$property][$this->getConstraintName($constraint)] = $constraint;
                    }
                }
            }
        }

        return json_encode($data);
    }

    /**
     *
     * @param Constraint $constraint
     * @return string 
     */
    protected function getConstraintName(Constraint $constraint)
    {
        $class = get_class($constraint);
        $parts = explode('\\', $class);
        return lcfirst(array_pop($parts));
    }

}
