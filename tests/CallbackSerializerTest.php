<?php

declare(strict_types=1);

namespace Yiisoft\Serializer\Tests;

use stdClass;
use Yiisoft\Serializer\CallbackSerializer;
use Yiisoft\Serializer\SerializerInterface;

final class CallbackSerializerTest extends SerializerTest
{
    public function getSerializer(): SerializerInterface
    {
        return new CallbackSerializer('serialize', 'unserialize');
    }

    public function serializeProvider(): array
    {
        return $this->dataProvider();
    }

    public function unserializeProvider(): array
    {
        return $this->dataProvider();
    }

    public function dataProvider(): array
    {
        return [
            'int' => [1, 'i:1;',],
            'float' => [1.1, 'd:1.1;',],
            'string' => ['a', 's:1:"a";',],
            'null' => [null, 'N;',],
            'bool' => [true, 'b:1;',],
            'object' => [new stdClass(), 'O:8:"stdClass":0:{}',],
            'array' => [[], 'a:0:{}',],
        ];
    }
}
