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

namespace SimpleThings\FormExtraBundle\Tests\Services;

use SimpleThings\FormExtraBundle\Service\JsValidationConstraintsGenerator;
use Symfony\Component\Validator\Constraints\Min;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class JsValidationConstraintsGeneratorTest extends \PHPUnit_Framework_TestCase
{
    private $generator;
    private $metadataFactory;

    public function setUp()
    {
        $this->metadataFactory = $this->getMock('Symfony\Component\Validator\Mapping\ClassMetadataFactoryInterface');
        $this->generator = new JsValidationConstraintsGenerator($this->metadataFactory);
    }

    public function testGenerateEmpty()
    {
        $this->assertEquals("[]", $this->generator->generate(array()));
    }

    public function testGenerate()
    {
        $constraint = new Min(array('limit' => 10));

        $cm = new ClassMetadata(__NAMESPACE__ . '\\TestEntity');
        $cm->addPropertyConstraint('field1', $constraint);
        $this->metadataFactory->expects($this->once())->method('getClassMetadata')->will($this->returnValue($cm));

        $data = $this->generator->generate(array(__NAMESPACE__ . '\\TestEntity'));
        $this->assertEquals('{"SimpleThings\\\\FormExtraBundle\\\\Tests\\\\Services\\\\TestEntity":{"field1":{"min":{"message":"This value should be {{ limit }} or more","invalidMessage":"This value should be a valid number","limit":10,"groups":["Default","TestEntity"]}}}}', $data);
    }

    public function testGenerateClass()
    {
        $constraint = new Min(array('limit' => 10));

        $cm = new ClassMetadata(__NAMESPACE__ . '\\TestEntity');
        $cm->addPropertyConstraint('field1', $constraint);
        $this->metadataFactory->expects($this->once())->method('getClassMetadata')->will($this->returnValue($cm));

        $data = $this->generator->generateClass(__NAMESPACE__ . '\\TestEntity');

        $this->assertArrayHasKey('field1', $data);
        $this->assertArrayHasKey('min', $data['field1']);
        $this->assertEquals($constraint, $data['field1']['min']);
    }
}

class TestEntity
{
    public $field1;
}

