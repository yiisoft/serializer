<?php

declare(strict_types=1);

namespace Yiisoft\Serializer\Tests;

use PHPUnit\Framework\TestCase;
use Yiisoft\Serializer\SerializerInterface;

abstract class SerializerTest extends TestCase
{
    /**
     * @dataProvider serializeProvider
     * @param $value
     * @param $expected
     */
    public function testSerialize($value, $expected): void
    {
        $serialized = $this->getSerializer()->serialize($value);
        $this->assertIsString($serialized);
        $this->assertEquals($expected, $serialized);
    }

    /**
     * @dataProvider unserializeProvider
     * @param $expected
     * @param $value
     */
    public function testUnserialize($expected, $value): void
    {
        $this->assertEquals($expected, $this->getSerializer()->unserialize($value));
    }

    abstract public function getSerializer(): SerializerInterface;

    abstract public function serializeProvider(): array;

    abstract public function unserializeProvider(): array;
}
