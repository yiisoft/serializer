<?php

namespace Yiisoft\Serializer;

/**
 * JsonSerializer serializes data in JSON format.
 */
final class JsonSerializer implements SerializerInterface
{
    /**
     * @param int integer the encoding options.
     * @see http://www.php.net/manual/en/function.json-encode.php
     */
    private int $options;

    /**
     * @param int $options integer the encoding options.
     * @see http://www.php.net/manual/en/function.json-encode.php
     */
    public function __construct(int $options = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
    {
        $this->options = $options;
    }

    /**
     * {@inheritDoc}
     *
     * @see json_encode()
     */
    public function serialize($value): string
    {
        return json_encode($value, $this->options);
    }

    /**
     * {@inheritDoc}
     *
     * @see json_decode()
     */
    public function unserialize(string $value)
    {
        return json_decode($value, true);
    }
}
