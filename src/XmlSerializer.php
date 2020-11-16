<?php

declare(strict_types=1);

namespace Yiisoft\Serializer;

use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * XmlSerializer serializes data in XML format.
 */
final class XmlSerializer implements SerializerInterface
{
    private Serializer $serializer;

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

    public function serialize($value): string
    {
        return $this->serializer->serialize($value, XmlEncoder::FORMAT);
    }

    public function unserialize(string $value)
    {
        return $this->serializer->decode($value, XmlEncoder::FORMAT);
    }
}
