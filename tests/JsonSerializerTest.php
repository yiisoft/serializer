<?php

namespace Yiisoft\Serializer\Tests;

use Yiisoft\Serializer\JsonSerializer;
use Yiisoft\Serializer\SerializerInterface;

class JsonSerializerTest extends SerializerTest
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
        $data['object'] = [[], '{}',];

        return $data;
    }

    public function dataProvider(): array
    {
        return [
            'integer' => [1, '1',],
            'double' => [1.1, '1.1',],
            'string' => ['a', '"a"',],
            'null' => [null, 'null',],
            'boolean' => [true, 'true',],
            'object' => [new \stdClass(), '{}',],
            'array' => [[], '[]',],
        ];
    }
}
