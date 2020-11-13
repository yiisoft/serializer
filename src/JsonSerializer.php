<?php

declare(strict_types=1);

namespace Yiisoft\Serializer;

use function json_decode;
use function json_encode;

/**
 * JsonSerializer serializes data in JSON format.
 */
final class JsonSerializer implements SerializerInterface
{
    /**
     * @param int The encoding options.
     * @see http://www.php.net/manual/en/function.json-encode.php
     */
    private int $options;

    /**
     * @param int $options The encoding options.
     * @see http://www.php.net/manual/en/function.json-encode.php
     */
    public function __construct(int $options = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
    {
        $this->options = $options;
    }

    public function serialize($value): string
    {
        return json_encode($value, $this->options);
    }

    public function unserialize(string $value)
    {
        return json_decode($value, true);
    }
}
