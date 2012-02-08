<?php
/**
 * SimpleThings FormExtraBundle
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace SimpleThings\FormExtraBundle\Extension;

use SimpleThings\FormExtraBundle\Service\JsValidationConstraintsGenerator;

/**
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
     * @var array
     */
    private $objects;

    /**
     *
     * @param ValidatorInterface $validator
     * @param array $objects
     */
    public function __construct(JsValidationConstraintsGenerator $generator, array $objects)
    {
        $this->generator = $generator;
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

    /**
     * Generates a JSON representation of the validation constraints that are
     * exported to the client-side.
     *
     * @return string
     */
    public function getValidationConstraints()
    {
        return $this->generator->generate($this->objects);
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
