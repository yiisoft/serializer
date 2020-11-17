<?php

declare(strict_types=1);

namespace Yiisoft\Serializer;

interface ObjectSerializerInterface
{
    /**
     * Serializes given object.
     *
     * @param object $object to be serialized.
     * @return string serialized object.
     */
    public function serialize(object $object): string;

    /**
     * Serializes given array objects.
     *
     * @param object[] $objects to be serialized.
     * @return string serialized array objects.
     */
    public function serializeMultiple(array $objects): string;

    /**
     * Restores object from its serialized representations.
     *
     * @param string $value The serialized string.
     * @param string $class The class name of the object to be restored.
     * @return object The restored object.
     */
    public function unserialize(string $value, string $class): object;

    /**
     * Restores array objects from its serialized representations.
     *
     * @param string $value The serialized string.
     * @param string $class The class name of the objects to be restored.
     * @return object[] The restored array objects.
     */
    public function unserializeMultiple(string $value, string $class): array;
}
