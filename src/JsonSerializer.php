<?php

declare(strict_types=1);

namespace Yiisoft\Serializer;

use const JSON_UNESCAPED_SLASHES;
use const JSON_UNESCAPED_UNICODE;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * JsonSerializer serializes data in JSON format.
 */
final class JsonSerializer implements SerializerInterface
{
    private Serializer $serializer;

    /**
     * @param int $options The encoding options.
     *
     * @see http://www.php.net/manual/en/function.json-encode.php
     */
    public function __construct(int $options = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
    {
        $this->serializer = new Serializer(
            [new JsonSerializableNormalizer(), new ObjectNormalizer()],
            [new JsonEncoder(
                new JsonEncode([JsonEncode::OPTIONS => $options]),
                new JsonDecode([JsonDecode::ASSOCIATIVE => true]),
            )],
        );
    }

    public function serialize($value): string
    {
        return $this->serializer->serialize($value, JsonEncoder::FORMAT);
    }

    public function unserialize(string $value)
    {
        return $this->serializer->decode($value, JsonEncoder::FORMAT);
    }
}
