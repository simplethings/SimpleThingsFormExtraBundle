<?php

namespace Comways\FormExtraBundle\DataTransformer;

use \htmlentities;

/**
 * Utilizes htmlentities to easy disallow all html inputs.
 *
 * example:
 *     $builder->get('my_field')->appendNormTransformer(new HtmlEntitiesTransformer(ENT_COMPAT, true));
 *
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 */
class HtmlEntitiesTransformer implements \Symfony\Component\Form\DataTransformerInterface
{

    /**
     * @var integer
     */
    protected $flags = ENT_COMPAT;

    /**
     * @var boolean
     */
    protected $doubleEncode = true;

    /**
     * @param integer $flags
     * @param Bollean $doubleEncode
     */
    public function __construct($flags = ENT_COMPAT, $doubleEncode = true)
    {
        $this->flags = $flags;
        $this->doubleEncode = true;
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
     * Cleans the parameter value by calling htmlentities. Also tries to determaine the charset
     * use.
     *
     * @param string $value
     * @return string
     */
    public function reverseTransform($value)
    {
        $charset = 'ISO-8859-1';

        if (function_exists('mb_detect_encoding')) {
            $charset = mb_detect_encoding($value, mb_detect_order(), true);
        }

        return htmlentities($value, $this->flags, $charset, $this->doubleEncode);
    }
}
