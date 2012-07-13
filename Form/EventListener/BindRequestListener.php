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

namespace SimpleThings\FormExtraBundle\Form\EventListener;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Exception\FormException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;

use SimpleThings\FormExtraBundle\Serializer\EncoderRegistry;
use SimpleThings\FormExtraBundle\Serializer\NamingStrategy\CamelCaseStrategy;

class BindRequestListener implements EventSubscriberInterface
{
    private $encoderRegistry;
    private $namingStrategy;

    public function __construct(EncoderRegistry $encoderRegistry)
    {
        $this->encoderRegistry = $encoderRegistry;
        $this->namingStrategy  = new CamelCaseStrategy();
    }

    public static function getSubscribedEvents()
    {
        // High priority in order to supersede other listeners
        return array(FormEvents::PRE_BIND => array('preBind', 129));
    }

    public function preBind(FormEvent $event)
    {
        $form    = $event->getForm();
        $request = $event->getData();

        if ( ! $request instanceof Request) {
            return;
        }

        $format = $request->getContentType();

        if ( ! $this->encoderRegistry->supportsEncoding($format)) {
            return;
        }

        $content = $request->getContent();
        $data    = $this->encoderRegistry
                        ->getEncoder($format)
                        ->decode($content, $format);

        $event->setData($this->unserializeForm($data, $form));
    }

    private function unserializeForm($data, $form)
    {
        if ( ! $form->hasChildren()) {
            return $data;
        }

        $result = array();

        foreach ($form->getChildren() as $child) {
            $options     = $child->getConfig()->getOptions();
            $name        = $this->namingStrategy->translateName($child);
            $isAttribute = isset($options['serialize_attribute']) && $options['serialize_attribute'];
            $value       = isset($data['@' . $name])
                ? $data['@' . $name]
                : (isset($data[$name]) ? $data[$name] : null);

            $result[$child->getName()] = $this->unserializeForm($value, $child);
        }

        return $result;
    }
}

