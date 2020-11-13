<?php

declare(strict_types=1);

namespace Yiisoft\Serializer;

/**
 * IgbinarySerializer uses [Igbinary PHP extension](http://pecl.php.net/package/igbinary) for serialization.
 * Make sure you have "igbinary" PHP extension install at your system before attempt to use this serializer.
 */
final class IgbinarySerializer implements SerializerInterface
{
    /**
     * {@inheritDoc}
     *
     * @see igbinary_serialize()
     */
    public function serialize($value): string
    {
        return igbinary_serialize($value);
    }

    /**
     * {@inheritDoc}
     *
     * @see unserialize()
     */
    public function unserialize(string $value)
    {
        return igbinary_unserialize($value);
    }
}
