<?php

declare(strict_types=1);

namespace Yiisoft\Serializer\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;
use Yiisoft\Serializer\Tests\TestAsset\DummyData;
use Yiisoft\Serializer\JsonObjectSerializer;

final class JsonObjectSerializerTest extends TestCase
{
    private JsonObjectSerializer $serializer;

    public function setUp(): void
    {
        $this->serializer = new JsonObjectSerializer();
    }

    public function testSerializeAndUnserialize(): void
    {
        $object = new DummyData('foo', 99, 1.1, [1, 'bar' => 'baz'], false);
        $json = json_encode([
            'string' => $object->getString(),
            'int' => $object->getInt(),
            'float' => $object->getFloat(),
            'array' => $object->getArray(),
            'bool' => $object->isBool(),
        ]);

        $this->assertSame($json, $this->serializer->serialize($object));
        $this->assertEquals($object, $this->serializer->unserialize($json, DummyData::class));
    }

    public function testSerializeMultipleAndUnserializeMultiple(): void
    {
        $objects = [
            $object1 = new DummyData('foo', 99, 1.1, [1], false),
            $object2 = new DummyData('bar', 10, 2.2, [1, 2, 3], true),
            $object3 = new DummyData('baz', 0, 3.3, ['foo' => 'bar'], false),
        ];
        $json = json_encode([
            [
                'string' => $object1->getString(),
                'int' => $object1->getInt(),
                'float' => $object1->getFloat(),
                'array' => $object1->getArray(),
                'bool' => $object1->isBool(),
            ],
            [
                'string' => $object2->getString(),
                'int' => $object2->getInt(),
                'float' => $object2->getFloat(),
                'array' => $object2->getArray(),
                'bool' => $object2->isBool(),
            ],
            [
                'string' => $object3->getString(),
                'int' => $object3->getInt(),
                'float' => $object3->getFloat(),
                'array' => $object3->getArray(),
                'bool' => $object3->isBool(),
            ],
        ]);

        $this->assertSame($json, $this->serializer->serializeMultiple($objects));
        $this->assertEquals($objects, $this->serializer->unserializeMultiple($json, DummyData::class));
    }

    public function testSerializeMultipleThrowExceptionForInvalidArrayObjects(): void
    {
        $serializer = new JsonObjectSerializer();
        $this->expectException(InvalidArgumentException::class);
        $serializer->serializeMultiple([new stdClass(), stdClass::class]);
    }

    public function testUnserializeThrowExceptionForClassNotExist(): void
    {
        $serializer = new JsonObjectSerializer();
        $this->expectException(InvalidArgumentException::class);
        $serializer->unserialize('{"foo":"bar"}', 'Class\Not\Exist');
    }

    public function testUnserializeMultipleThrowExceptionForClassNotExist(): void
    {
        $serializer = new JsonObjectSerializer();
        $this->expectException(InvalidArgumentException::class);
        $serializer->unserializeMultiple('{"foo":"bar"}', 'Class\Not\Exist');
    }

    public function testUnserializeThrowExceptionForIncorrectData(): void
    {
        $serializer = new JsonObjectSerializer();
        $this->expectException(InvalidArgumentException::class);
        $serializer->unserialize('{"foo":"bar"}', DummyData::class);
    }

    public function testUnserializeMultipleThrowExceptionForIncorrectData(): void
    {
        $serializer = new JsonObjectSerializer();
        $this->expectException(InvalidArgumentException::class);
        $serializer->unserializeMultiple('{"foo":"bar"}', DummyData::class);
    }
}
