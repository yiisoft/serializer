<?php

declare(strict_types=1);

namespace Yiisoft\Serializer\Tests;

use function json_encode;
use stdClass;
use Yiisoft\Serializer\JsonSerializer;
use Yiisoft\Serializer\SerializerInterface;
use Yiisoft\Serializer\Tests\TestAsset\DummyData;

use Yiisoft\Serializer\Tests\TestAsset\DummyDataJsonSerializable;

final class JsonSerializerTest extends SerializerTest
{
    public function getSerializer(): SerializerInterface
    {
        return new JsonSerializer();
    }

    public function serializeProvider(): array
    {
        return $this->dataProvider();
    }

    public function unserializeProvider(): array
    {
        $data = $this->dataProvider();
        $data['empty-object'] = [[], '[]',];

        return $data;
    }

    public function dataProvider(): array
    {
        return [
            'int' => [1, '1',],
            'float' => [1.1, '1.1',],
            'string' => ['a', '"a"',],
            'null' => [null, 'null',],
            'bool' => [true, 'true',],
            'empty-object' => [new stdClass(), '[]',],
            'empty-array' => [[], '[]',],
            'array' => [
                $array = [1, 1.1, 'a', null, true, [1, 1.1, 'a', null, false]],
                json_encode($array),
            ],
        ];
    }

    public function testSerializeAndUnserializeObject(): void
    {
        $serializer = new JsonSerializer();
        $object = new DummyData('foo', 99, 1.1, [1, 'bar' => 'baz'], false);
        $array = [
            'string' => $object->getString(),
            'int' => $object->getInt(),
            'float' => $object->getFloat(),
            'array' => $object->getArray(),
            'bool' => $object->isBool(),
        ];
        $json = json_encode($array);

        $this->assertSame($json, $serializer->serialize($object));
        $this->assertSame($array, $serializer->unserialize($json));
    }

    public function testSerializeJsonSerializableObject(): void
    {
        $serializer = new JsonSerializer();
        $object = new DummyDataJsonSerializable('foo');

        $this->assertSame('{"data":"jsonSerialize"}', $serializer->serialize($object));
    }
}
