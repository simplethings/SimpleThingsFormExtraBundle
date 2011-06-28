<?php

namespace SimpleThings\FormExtraBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * Utilizes htmlentities to easy disallow all html inputs.
 *
 * example:
 *     $builder->get('my_field')->appendNormTransformer(new HtmlEntitiesTransformer(ENT_COMPAT, true));
 *
 * @author Henrik Bjornskov <henrik@bjrnskov.dk>
 */
class HtmlEntitiesTransformer implements DataTransformerInterface
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
        return htmlentities($value, $this->flags, $this->guessCharset($value), $this->doubleEncode);
    }

    /**
     * Tries to guess the charset by using mb_* functions. If mbstring extension
     * is not enabled it will always return ISO-8859-1
     *
     * @param string $value
     * @return string
     */
    protected function guessCharset($value)
    {
        if (function_exists('mb_detect_encoding')) {
            $charset = mb_detect_encoding($value, mb_detect_order(), true);
            if ($charset != 'ASCII') {
                return $charset;
            }
        }

        return 'ISO-8859-1';
    }
}
