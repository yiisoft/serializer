<?php

declare(strict_types=1);

namespace Yiisoft\Serializer;

use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * XmlObjectSerializer serializes objects in XML format and vice versa.
 */
final class XmlObjectSerializer implements ObjectSerializerInterface
{
    use ObjectSerializerTrait;

    /**
     * @param string $rootTag The name of the root element.
     * @param string $version The XML version.
     * @param string $encoding The XML encoding.
     */
    public function __construct(string $rootTag = 'response', string $version = '1.0', string $encoding = 'UTF-8')
    {
        $this->serializer = new Serializer([new ObjectNormalizer()], [new XmlEncoder([
            XmlEncoder::ROOT_NODE_NAME => $rootTag,
            XmlEncoder::VERSION => $version,
            XmlEncoder::ENCODING => $encoding,
        ])]);
    }

    public function serialize(object $object): string
    {
        return $this->serializer->serialize($object, XmlEncoder::FORMAT);
    }

    public function serializeMultiple(array $objects): string
    {
        $this->checkArrayObjects($objects);
        return $this->serializer->serialize($objects, XmlEncoder::FORMAT);
    }

    public function unserialize(string $value, string $class): object
    {
        $decodedValue = $this->checkAndDecodeData($value, $class, XmlEncoder::FORMAT);
        return $this->denormalizeObject($decodedValue, $class);
    }

    public function unserializeMultiple(string $value, string $class): array
    {
        $decodedValue = $this->checkAndDecodeData($value, $class, XmlEncoder::FORMAT);
        return $this->denormalizeObjects($decodedValue, $class);
    }
}
