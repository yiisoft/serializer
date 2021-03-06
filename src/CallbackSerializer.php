<?php

declare(strict_types=1);

namespace Yiisoft\Serializer;

/**
 * CallbackSerializer serializes data via custom PHP callback.
 */
final class CallbackSerializer implements SerializerInterface
{
    /**
     * @var callable PHP callback, which should be used to serialize value.
     */
    private $serializeCallback;

    /**
     * @var callable PHP callback, which should be used to unserialize value.
     */
    private $unserializeCallback;

    /**
     * @param callable $serializeCallback PHP callback, which should be used to serialize value.
     * @param callable $unserializeCallback PHP callback, which should be used to unserialize value.
     */
    public function __construct(callable $serializeCallback, callable $unserializeCallback)
    {
        $this->serializeCallback = $serializeCallback;
        $this->unserializeCallback = $unserializeCallback;
    }

    public function serialize($value): string
    {
        return ($this->serializeCallback)($value);
    }

    public function unserialize(string $value)
    {
        return ($this->unserializeCallback)($value);
    }
}
