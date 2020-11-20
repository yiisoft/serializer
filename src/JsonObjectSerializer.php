<?php

declare(strict_types=1);

namespace Yiisoft\Serializer;

use const JSON_UNESCAPED_SLASHES;
use const JSON_UNESCAPED_UNICODE;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * JsonObjectSerializer serializes objects in JSON format and vice versa.
 */
final class JsonObjectSerializer implements ObjectSerializerInterface
{
    use ObjectSerializerTrait;

    /**
     * @param int $options The encoding options.
     *
     * @see http://www.php.net/manual/en/function.json-encode.php
     */
    public function __construct(int $options = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
    {
        $this->serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder(
            new JsonEncode([JsonEncode::OPTIONS => $options]),
            new JsonDecode([JsonDecode::ASSOCIATIVE => true]),
        )]);
    }

    public function serialize(object $object): string
    {
        return $this->serializer->serialize($object, JsonEncoder::FORMAT);
    }

    public function serializeMultiple(array $objects): string
    {
        $this->checkArrayObjects($objects);
        return $this->serializer->serialize($objects, JsonEncoder::FORMAT);
    }

    public function unserialize(string $value, string $class): object
    {
        $decodedValue = $this->checkAndDecodeData($value, $class, JsonEncoder::FORMAT);
        return $this->denormalizeObject($decodedValue, $class);
    }

    public function unserializeMultiple(string $value, string $class): array
    {
        $decodedValue = $this->checkAndDecodeData($value, $class, JsonEncoder::FORMAT);
        return $this->denormalizeObjects($decodedValue, $class);
    }
}
