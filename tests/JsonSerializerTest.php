<?php

declare(strict_types=1);

namespace Yiisoft\Serializer\Tests;

use stdClass;
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
            'int' => [1, '1',],
            'float' => [1.1, '1.1',],
            'string' => ['a', '"a"',],
            'null' => [null, 'null',],
            'bool' => [true, 'true',],
            'object' => [new stdClass(), '{}',],
            'array' => [[], '[]',],
        ];
    }
}
