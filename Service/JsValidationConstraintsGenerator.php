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

namespace SimpleThings\FormExtraBundle\Service;

use Symfony\Component\Validator\Mapping\ClassMetadataFactoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Translation\Translator;

/**
 * @author david badura <badura@simplethings.de>
 */
class JsValidationConstraintsGenerator
{
    /**
     * @var ClassMetadataFactoryInterface
     */
    protected $metadataFactory;

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @var string
     */
    protected $defaultLocale;

    /**
     * @param metadataFactoryInterface $metadataFactory
     */
    public function __construct(ClassMetadataFactoryInterface $metadataFactory, Translator $translator = null, $defaultLocale = null)
    {
        $this->metadataFactory = $metadataFactory;
        $this->translator = $translator;
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * @param array $classNames
     * @return string
     */
    public function generate(array $classNames)
    {
        $data = array();
        foreach ($classNames as $className) {
            $data[$className] = $this->generateClass($className);
        }

        return json_encode($data);
    }

    /**
     * Generate array representation of constraints that is exported to JSON.
     *
     * @todo export class constraints
     * @todo filter exported contraints?
     * @param string $className
     * @return array
     */
    public function generateClass($className)
    {
        $data = array();

        $metadata = $this->metadataFactory->getClassMetadata($className);
        $properties = $metadata->getConstrainedProperties();

        foreach ($properties as $property) {
            $data[$property] = array();
            $constraintsList = $metadata->getMemberMetadatas($property);
            foreach ($constraintsList as $constraints) {
                foreach ($constraints->constraints as $constraint) {
                    $const = clone $constraint;
                    if ($this->translator) {
                        $const->message = $this->translator->trans($const->message, array(), 'validations', $this->defaultLocale);
                    }
                    $data[$property][$this->getConstraintName($const)] = $const;
                }
            }
        }

        return $data;
    }

    /**
     * @todo Only shorten symfony ones and underscore/camlize others?
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

