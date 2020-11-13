<?php

declare(strict_types=1);

namespace Yiisoft\Serializer;

use function serialize;
use function unserialize;

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
