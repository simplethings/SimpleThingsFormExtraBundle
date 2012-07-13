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

namespace SimpleThings\FormExtraBundle\Serializer\NamingStrategy;

use Symfony\Component\Form\FormInterface;

class CamelCaseStrategy implements NamingStrategy
{
    public function translateName(FormInterface $form)
    {
        return strtolower(preg_replace('/[A-Z]/', '_\\0', $form->getName()));
    }
}

