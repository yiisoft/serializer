<?php

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
    public function testSerialize($value, $expected)
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
    public function testUnserialize($expected, $value)
    {
        $this->assertEquals($expected, $this->getSerializer()->unserialize($value));
    }

    /**
     * @return SerializerInterface
     */
    abstract public function getSerializer(): SerializerInterface;

    /**
     * @return array
     */
    abstract public function serializeProvider(): array;

    /**
     * @return array
     */
    abstract public function unserializeProvider(): array;
}
