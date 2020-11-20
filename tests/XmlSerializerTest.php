<?php

declare(strict_types=1);

namespace Yiisoft\Serializer\Tests;

use stdClass;
use Yiisoft\Serializer\SerializerInterface;
use Yiisoft\Serializer\Tests\TestAsset\DummyData;
use Yiisoft\Serializer\Tests\TestAsset\DummyDataHelper;
use Yiisoft\Serializer\XmlSerializer;

final class XmlSerializerTest extends SerializerTest
{
    public function getSerializer(): SerializerInterface
    {
        return new XmlSerializer();
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
        $data = [
            'int' => [1, '<response>1</response>',],
            'float' => [1.1, '<response>1.1</response>',],
            'string' => ['a', '<response>a</response>',],
            'null' => [null, '<response/>',],
            'array' => [
                [
                    'int' => 1,
                    'float' => 1.1,
                    'string' => 'a',
                    'null' => null,
                    'without-key-1',
                    'without-key-2',
                    'nested' => [
                        'int' => 1,
                        'float' => 1.1,
                        'string' => 'a',
                        'null' => null,
                        'without-key-1',
                        'without-key-2',
                    ],
                ],
                <<<EOF
                    <response>
                        <int>1</int>
                        <float>1.1</float>
                        <string>a</string>
                        <null/>
                        <item key="0">without-key-1</item>
                        <item key="1">without-key-2</item>
                        <nested>
                            <int>1</int>
                            <float>1.1</float>
                            <string>a</string>
                            <null/>
                            <item key="0">without-key-1</item>
                            <item key="1">without-key-2</item>
                        </nested>
                    </response>
                EOF,
            ],
        ];

        foreach ($data as $key => $value) {
            $value[1] = DummyDataHelper::xml($value[1]);
            $data[$key] = $value;
        }

        return $data;
    }

    public function testConstructorWithPassedArguments(): void
    {
        $serializer = new XmlSerializer($rootTag = 'foo', $version = '2.0', $encoding = 'Windows-1252');
        $this->assertSame(
            DummyDataHelper::xml("<{$rootTag}/>", $version, $encoding),
            $serializer->serialize([])
        );
    }

    public function testSerializeEmptyObject(): void
    {
        $serializer = new XmlSerializer();
        $this->assertSame(DummyDataHelper::xml('<response/>'), $serializer->serialize(new stdClass()));
    }

    public function testSerializeAndUnserialize(): void
    {
        $serializer = new XmlSerializer();
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
        $array = [
            'string' => $object->getString(),
            'int' => $object->getInt(),
            'float' => $object->getFloat(),
            'array' => $object->getArray(),
            'bool' => (string) $object->isBool(true),
        ];

        $this->assertSame(DummyDataHelper::xml($xml), $serializer->serialize($object));
        $this->assertEquals($array, $serializer->unserialize($xml));
    }
}
