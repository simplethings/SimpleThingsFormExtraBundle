<?php
/**
 * Beberlei Form Serializer
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace SimpleThings\FormExtraBundle\Form;

use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\AbstractExtension;

use SimpleThings\FormExtraBundle\Form\Extension\SerializerTypeExtension;

class SerializerExtension extends AbstractExtension
{
    private $encoderRegistry;

    public function __construct($encoderRegistry)
    {
        $this->encoderRegistry = $encoderRegistry;
    }

    protected function loadTypeExtensions()
    {
        return array(new SerializerTypeExtension($this->encoderRegistry));
    }
}

