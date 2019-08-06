<?php

namespace Yiisoft\Serializer;

/**
 * PhpSerializer uses native PHP {@see serialize()} and {@see unserialize()} functions for serialization.
 */
final class PhpSerializer implements SerializerInterface
{
    /**
     * @inheritDoc
     */
    public function serialize($value): string
    {
        return serialize($value);
    }

    /**
     * @inheritDoc
     */
    public function unserialize(string $value)
    {
        return unserialize($value);
    }
}
