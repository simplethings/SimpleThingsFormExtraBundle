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

namespace SimpleThings\FormExtraBundle\Tests\Serializer;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormRegistry;
use Symfony\Component\Form\Extension\Core\CoreExtension;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\HttpFoundation\Request;

use SimpleThings\FormExtraBundle\Serializer\FormSerializer;
use SimpleThings\FormExtraBundle\Serializer\EncoderRegistry;
use SimpleThings\FormExtraBundle\Form\SerializerExtension;

class FormSerializerTest extends \PHPUnit_Framework_TestCase
{
    public function testFunctional()
    {
        $registry = new EncoderRegistry(array(new XmlEncoder, new JsonEncoder));
        $factory = new FormFactory(new FormRegistry(array(
                        new CoreExtension(),
                        new SerializerExtension($registry)
                        )));

        $address          = new Address();
        $address->street  = "Somestreet 1";
        $address->zipCode = 12345;
        $address->city    = "Bonn";

        $user           = new User();
        $user->username = "beberlei";
        $user->email    = "kontakt@beberlei.de";
        $user->birthday = new \DateTime("1984-03-18");
        $user->country  = "DE";
        $user->address  = $address;

        $builder = $factory->createBuilder('form', null, array('data_class' => __NAMESPACE__ . '\\User', 'serialize_xml_root' => 'user'));
        $builder
            ->add('username', 'text')
            ->add('email', 'email')
            ->add('birthday', 'date', array('widget' => 'single_text'))
            ->add('country', 'country')
            ->add('address', null, array('compound' => true, 'data_class' => __NAMESPACE__ . '\\Address'))
            ;

        $addressBuilder = $builder->get('address');
        $addressBuilder
            ->add('street', 'text', array('serialize_attribute' => true))
            ->add('zipCode', 'text', array('serialize_attribute' => true))
            ->add('city', 'text', array('serialize_attribute' => true))
            ;

        $formSerializer = new FormSerializer($factory, $registry);
        $xml           = $formSerializer->serialize($user, $builder, 'xml');

        $dom = new \DOMDocument;
        $dom->loadXml($xml);
        $dom->formatOutput = true;

        /*
           <?xml version="1.0"?>
           <user>
           <username>beberlei</username>
           <email>kontakt@beberlei.de</email>
           <birthday>1984-03-18</birthday>
           <country>DE</country>
           <address street="Somestreet 1" zip_code="12345" city="Bonn"/>
           </user>
         */

        $json = $formSerializer->serialize($user, $builder, 'json');
        /*
           {
           "username":"beberlei",
           "email":"kontakt@beberlei.de",
           "birthday":"1984-03-18",
           "country":"DE",
           "address":{"street":"Somestreet 1","zip_code":"12345","city":"Bonn"}
           }*/

        $user2 = new User;
        $form = $builder->getForm();
        $form->setData($user2);

        $request = new Request(array(), array(),array(),array(),array(),array(
                    'CONTENT_TYPE' => 'text/xml',
                    ), $xml);

        $form->bind($request);

        $user3 = new User;
        $form = $builder->getForm();
        $form->setData($user3);

        $request = new Request(array(), array(),array(),array(),array(),array(
                    'CONTENT_TYPE' => 'application/json',
                    ), $json);
        $form->bind($request);

        $this->assertEquals($user2, $user);
        $this->assertEquals($user3, $user);
    }
}

class User
{
    public $username;
    public $email;
    public $country;
    public $birthday;
    public $addresses;
    public $created;
    public $address;
}

class Address
{
    public $street;
    public $zipCode;
    public $city;
}
