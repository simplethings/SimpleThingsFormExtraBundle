<?php

namespace SimpleThings\FormExtraBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * Utilizes strip_tags to easy strip tags from fields.
 *
 * example:
 *     $builder->get('my_field')->appendNormTransformer(new StripTagsTransformer('<p>'));
 *
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 */
class StripTagsTransformer implements DataTransformerInterface
{
    /**
     * @var string
     */
    protected $allowedTags = '';

    /**
     * @param string $allowedTags list of tags to allow see php.net/strip_tags
     */
    public function __construct($allowedTags = '')
    {
        $this->allowedTags = $allowedTags;
    }

    /**
     * Not Used
     *
     * @param string $value
     * @return string
     */
    public function transform($value)
    {
        return $value;
    }

    /**
     * Cleans the parameter value by called strip_tags.
     *
     * @param string $value
     * @return string
     */
    public function reverseTransform($value)
    {
        return strip_tags($value, $this->allowedTags);
    }
}
