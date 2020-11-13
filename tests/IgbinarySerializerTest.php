<?php

declare(strict_types=1);

namespace Yiisoft\Serializer\Tests;

use Yiisoft\Serializer\IgbinarySerializer;
use Yiisoft\Serializer\SerializerInterface;

class IgbinarySerializerTest extends SerializerTest
{
    public static function setUpBeforeClass(): void
    {
        if (!extension_loaded('igbinary')) {
            static::markTestSkipped('igbinary extension is not loaded');
        }
        parent::setUpBeforeClass();
    }

    public function getSerializer(): SerializerInterface
    {
        return new IgbinarySerializer();
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
            'int' => [1, hex2bin('000000020601'),],
            'float' => [1.1, hex2bin('000000020c3ff199999999999a'),],
            'string' => ['a', hex2bin('00000002110161'),],
            'null' => [null, hex2bin('0000000200'),],
            'bool' => [true, hex2bin('0000000205'),],
            'object' => [new \stdClass(), hex2bin('000000021708737464436c6173731400'),],
            'array' => [[], hex2bin('000000021400'),],
        ];
    }
}
