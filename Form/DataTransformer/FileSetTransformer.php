<?php

namespace SimpleThings\FormExtraBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * Turn any value recieved from the fileset field into a null value.
 * 
 * @author Benjamin Eberlei <eberlei@simplethings.de>
 */
class FileSetTransformer implements DataTransformerInterface
{
    public function reverseTransform($value)
    {
        return $value;
    }
    
    public function transform($value)
    {
        return "";
    }
}
