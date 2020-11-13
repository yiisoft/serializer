<?php

namespace Yiisoft\Serializer;

/**
 * PhpSerializer uses native PHP functions for serialization.
 */
final class PhpSerializer implements SerializerInterface
{
    /**
     * {@inheritDoc}
     *
     * @see serialize()
     */
    public function serialize($value): string
    {
        return serialize($value);
    }

    /**
     * {@inheritDoc}
     *
     * @see unserialize()
     */
    public function unserialize(string $value)
    {
        return unserialize($value);
    }
}
