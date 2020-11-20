<?php

declare(strict_types=1);

namespace Yiisoft\Serializer\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;
use Yiisoft\Serializer\Tests\TestAsset\DummyData;
use Yiisoft\Serializer\Tests\TestAsset\DummyDataHelper;
use Yiisoft\Serializer\XmlObjectSerializer;

final class XmlObjectSerializerTest extends TestCase
{
    public function testConstructorDefault(): void
    {
        $serializer = new XmlObjectSerializer();
        $this->assertSame(
            DummyDataHelper::xml('<response/>'),
            $serializer->serialize(new stdClass())
        );
    }

    public function testConstructorWithPassedArguments(): void
    {
        $serializer = new XmlObjectSerializer($rootTag = 'foo', $version = '2.0', $encoding = 'Windows-1252');
        $this->assertSame(
            DummyDataHelper::xml("<{$rootTag}/>", $version, $encoding),
            $serializer->serialize(new stdClass())
        );
    }

    public function testSerializeEmptyObject(): void
    {
        $serializer = new XmlObjectSerializer();
        $this->assertSame(DummyDataHelper::xml('<response/>'), $serializer->serialize(new stdClass()));
    }

    public function testSerializeAndUnserialize(): void
    {
        $serializer = new XmlObjectSerializer();
        $object = new DummyData('foo', 99, 1.1, [1, 'foo' => 'bar'], false);
        $xml = <<<EOF
            <response>
                <string>{$object->getString()}</string>
                <int>{$object->getInt()}</int>
                <float>{$object->getFloat()}</float>
                <array>
                    <item key="0">1</item>
                    <foo>bar</foo>
                </array>
                <bool>{$object->isBool(true)}</bool>
            </response>
        EOF;

        $this->assertSame(DummyDataHelper::xml($xml), $serializer->serialize($object));
        $this->assertEquals($object, $serializer->unserialize($xml, DummyData::class));
    }

    public function testSerializeMultipleAndUnserializeMultiple(): void
    {
        $serializer = new XmlObjectSerializer();
        $objects = [
            $object1 = new DummyData('foo', 99, 1.1, ['foo', 1.1], false),
            $object2 = new DummyData('bar', 10, 2.2, [1, 2, 3], true),
            $object3 = new DummyData('baz', 0, 3.3, ['bar' => 'baz'], false),
        ];
        $xml = <<<EOF
            <response>
                <item key="0">
                    <string>{$object1->getString()}</string>
                    <int>{$object1->getInt()}</int>
                    <float>{$object1->getFloat()}</float>
                    <array>foo</array>
                    <array>1.1</array>
                    <bool>{$object1->isBool(true)}</bool>
                </item>
                <item key="1">
                    <string>{$object2->getString()}</string>
                    <int>{$object2->getInt()}</int>
                    <float>{$object2->getFloat()}</float>
                    <array>1</array>
                    <array>2</array>
                    <array>3</array>
                    <bool>{$object2->isBool(true)}</bool>
                </item>
                <item key="2">
                    <string>{$object3->getString()}</string>
                    <int>{$object3->getInt()}</int>
                    <float>{$object3->getFloat()}</float>
                    <array><bar>baz</bar></array>
                    <bool>{$object3->isBool(true)}</bool>
                </item>
            </response>
        EOF;

        $this->assertSame(DummyDataHelper::xml($xml), $serializer->serializeMultiple($objects));
        $this->assertEquals($objects, $serializer->unserializeMultiple($xml, DummyData::class));
    }

    public function testSerializeMultipleThrowExceptionForInvalidArrayObjects(): void
    {
        $serializer = new XmlObjectSerializer();
        $this->expectException(InvalidArgumentException::class);
        $serializer->serializeMultiple([new stdClass(), stdClass::class]);
    }

    public function testUnserializeThrowExceptionForClassNotExist(): void
    {
        $serializer = new XmlObjectSerializer();
        $this->expectException(InvalidArgumentException::class);
        $serializer->unserialize('<foo>bar</foo>', 'Class\Not\Exist');
    }

    public function testUnserializeMultipleThrowExceptionForClassNotExist(): void
    {
        $serializer = new XmlObjectSerializer();
        $this->expectException(InvalidArgumentException::class);
        $serializer->unserializeMultiple('<foo>bar</foo>', 'Class\Not\Exist');
    }

    public function testUnserializeThrowExceptionForIncorrectData(): void
    {
        $serializer = new XmlObjectSerializer();
        $this->expectException(InvalidArgumentException::class);
        $serializer->unserialize('<foo>bar</foo>', DummyData::class);
    }

    public function testUnserializeMultipleThrowExceptionForIncorrectData(): void
    {
        $serializer = new XmlObjectSerializer();
        $this->expectException(InvalidArgumentException::class);
        $serializer->unserializeMultiple('<foo>bar</foo>', DummyData::class);
    }
}
