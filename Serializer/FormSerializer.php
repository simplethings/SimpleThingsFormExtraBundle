<?php
/**
 * SimpleThings FormExtraBundle
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace SimpleThings\FormExtraBundle\Serializer;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\TypeInterface;
use Symfony\Component\Form\FormBuilderInterface;

use SimpleThings\FormExtraBundle\Serializer\NamingStrategy\CamelCaseStrategy;

class FormSerializer
{
    private $factory;
    private $encoderRegistry;
    private $namingStrategy;

    public function __construct(FormFactoryInterface $factory, EncoderRegistry $encoderRegistry)
    {
        $this->factory         = $factory;
        $this->encoderRegistry = $encoderRegistry;
        $this->namingStrategy  = new CamelCaseStrategy();
    }

    public function serialize($object, $typeBuilder, $format)
    {
        if ($typeBuilder instanceof TypeInterface) {
            $form = $this->factory->create($typeBuilder, $object);
        } else if ($typeBuilder instanceof FormBuilderInterface) {
            $form = $typeBuilder->getForm();
            $form->setData($object);
        } else {
            throw new \RuntimeException();
        }

        $options = $form->getConfig()->getOptions();
        $xmlName = isset($options['serialize_xml_root'])
            ? $options['serialize_xml_root']
            : 'entry';

        $data = $this->serializeForm($form, $format == 'xml');

        $this->encoderRegistry->getEncoder('xml')->setRootNodeName($xmlName);

        return $this->encoderRegistry
                    ->getEncoder($format)
                    ->encode($data, $format);
    }

    private function serializeForm($form, $isXml)
    {
        if ( ! $form->hasChildren()) {
            return $form->getViewData();
        }

        foreach ($form->getChildren() as $child) {
            $options = $child->getConfig()->getOptions();
            $name    = $this->namingStrategy->translateName($child);
            $name    = $isXml && $options['serialize_attribute'] ? '@' . $name : $name;

            $data[$name] = $this->serializeForm($child, $isXml);
        }

        return $data;
    }
}

